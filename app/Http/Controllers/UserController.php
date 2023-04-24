<?php

namespace App\Http\Controllers;

use App\Exports\ContractsExport;
use App\Models\City;
use App\Models\Contract;
use App\Models\Country;
use App\Models\Payment;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use mysql_xdevapi\Collection;

class UserController extends Controller
{
    public function index ()
    {
        $countries = Country::get(['name','id']);
        return view('register', ['countries' => $countries, 'error' => '']);
    }
    public function getStates (Request $request)
    {
        $states = State::where('country_id', '=', $request->country_id)->get(['name','id']);
        return response()->json(['success' => true, 'states' => $states]);
    }
    public function getCities (Request $request)
    {
        $cities = City::where('state_id', '=', $request->state_id)->get(['name','id']);
        return response()->json(['success' => true, 'cities' => $cities]);
    }
    public function register (Request $request)
    {
        $credentials = $request->only('email', 'password', 'password_confirmation');
        $validator = Validator::make($credentials, [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required',
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            $response = ['success' => false, 'error' => $validator->errors()->first(), 'countries' => Country::get(['name','id'])];
            return view('register', $response);
        }
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'country' => null,
            'state' => null,
            'city' => null
        ]);
        if (Country::where('id', $request->country)->first()) {
            User::where('email', $request->email)->update([
                'country' => Country::where('id', $request->country)->first()->name,
            ]);
        }
        if (State::where('id', $request->state)->first()) {
            User::where('email', $request->email)->update([
                'state' => State::where('id', $request->state)->first()->name,
            ]);
        }
        if (City::where('id', $request->city)->first()) {
            User::where('email', $request->email)->update([
                'city' => city::where('id', $request->city)->first()->name,
            ]);
        }
        event(new Registered($user));
        if (!Auth::attempt($request->only('email', 'password'))) {
            $response = ['success' => false, 'error' => 'Invalid email or username', 'countries' => Country::get(['name','id'])];
            return view('register', $response);
        }
        return redirect('home');
    }
    public function login (Request $request)
    {
        $validator = Validator::make($request->only(['email', 'password']), [
            'email' => 'required|email',
            'password' => 'required|alpha_num',
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            $response = ['success' => false, 'error' => $validator->errors()->first()];
            return view('login', $response);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            $response = ['success' => false, 'error' => 'Invalid email or username'];
            return view('login', $response);
        }
        return redirect('home');
    }
    public function changeLang (Request $request)
    {
        App::setLocale($request->lang);
        session()->put('locale', $request->lang);
        return response()->json(["success" => true, "lang" => $request->lang]);
    }
    private array $data = Array();
    private int $count = 0;
    public function parseXML ()
    {
        $allFiles = Storage::disk('public')->allFiles('xml');
        foreach ($allFiles as $xmlFileLink) {
            $this->data = [];
            $xmlFile = Storage::disk('public')->get($xmlFileLink);
            $xml = simplexml_load_string($xmlFile);
            $json = json_encode($xml);
            $array = json_decode($json,TRUE);
            $this->parseData($array);
            $parsedData = $this->data;
            $contract = $this->createCotract($parsedData);
            Excel::store(
                new ContractsExport($contract),
                'xlsx/contract_'.$contract['id'].'.xlsx',
                'public'
            );
        }
        $contracts = Contract::all()->toArray();
        Mail::send("sendExcel", $contracts, function ($message) use ($contracts) {
            $message->from("Sashka@mail.com", "Sashka");
            $message->to("Sashka@mail.com");
            foreach ($contracts as $contract) {
                $message->attach(public_path("storage/xlsx/contract_".$contract["id"].".xlsx"));
            }
        });
    }

    public function parseData ($array)
    {
        foreach ($array as $key => $value) {
            if ($key == "ПериодДействия") {
                $test = explode(" ", $value);
                $this->data['created_at'] = $test[1];
                $this->data['expires_at'] = $test[3];
            } elseif (gettype($value) !== 'array') {
                $this->data[$key] = $value;
            } elseif ($key == "Платежи") {
                $this->parsePayments($value);
            } else {
                $this->parseData($value);
            }
        }
    }
    public function parsePayments ($array)
    {
        foreach ($array as $key => $value) {
            if (gettype($value) !== 'array') {
                $this->data['Платежи'][$this->count][$key] = $value;
            } else {
                $this->parsePayments($value);
            }
        }
        if (count($array) > 1) {
            $this->count++;
        }
    }
    public function createCotract ($parsedData)
    {
        $contract = Contract::create([
            "subject" => $parsedData["ПредметДоговора"],
            "provider" => $parsedData["Поставщик"],
            "price" => $parsedData["КонтрактнаяСтоимость"],
            "prepayment" => $parsedData["СуммаАвансовогоПлатежа"],
            "total_payment" => $parsedData["ОбщаяСуммаПлатежа"],
            "created_at" => Carbon::createFromFormat("d.m.Y", $parsedData["created_at"], "Europe/Kiev")
                ->toDateTimeString(),
            "expires_at" => Carbon::createFromFormat("d.m.Y", $parsedData["expires_at"], "Europe/Kiev")
                ->toDateTimeString(),
            "contract_number" => $parsedData["НомерДоговора"],
            "status" => $parsedData["СтатусДоговора"],
        ]);
        foreach ($parsedData["Платежи"] as $value) {
            Payment::create([
                "contract_id" => $contract->id,
                "payment_number" => $value["НомерПлатежа"],
                "billing_month" => $value["РасчетныйМесяц"],
                "prepayment" => $value["СуммаАвансовогоПлатежа"],
                "total" => $value["ИтогоКОплатеСНДС"],
            ]);
        }
        return Contract::find($contract->id)->toArray();
    }
}
