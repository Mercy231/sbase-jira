<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Smalot\PdfParser\Parser;

class PdfController extends Controller
{
    public function index () : View
    {
        return view("parsePDF");
    }
    public function read (Request $request) : JsonResponse
    {
        foreach ($_FILES as $file) {
            $response = Array();
            $pdfParser = new Parser();
            $str = $pdfParser->parseFile($file['tmp_name'])->getText();
            $parsed = array_map('trim', preg_split('/\n|\t|\t\n/', $str));
            foreach ($parsed as $key => $value) {
                switch ($value) {
                    case ":":
                    case "":
                    case "#N/A":
                    case "Report ID:":
                        unset($parsed[$key]);
                        break;
                    default:
                        break;
                }
            }
            $parsed = array_values($parsed);
            foreach ($parsed as $key => $value) {
                switch ($value) {
                    case "Candidate Name":
                        $response["Candidate Name"] = $parsed[$key + 5];
                        break;
                    case "Test Date":
                        $response["Test Date"] = $parsed[$key + 1];
                        break;
                    case "Overall Score:":
                        $response["Grade"] = $parsed[$key + 1];
                        break;
                    case "Accuracy Score:":
                        $response["Source"] = $parsed[$key + 1];
                        $response["Target"] = $parsed[$key + 2];
                        break;
                    case "Accent/Pronunciation":
                        if (array_key_exists("Accent/Pron", $response) && $parsed[$key + 1] == "Grammar and Syntax") {
                            $response["Accent/Pron(2)"] = null;
                        } elseif (array_key_exists("Accent/Pron", $response)) {
                            $response["Accent/Pron(2)"] = $parsed[$key + 1];
                            $response["Accent/Pron(2)"] = str_replace(": ", "", $response["Accent/Pron(2)"]);
                        } else {
                            $response["Accent/Pron"] = $parsed[$key + 1];
                        }
                        break;
                    case "Grammar and Syntax":
                        if (array_key_exists("Grammar and Syntax", $response) && $parsed[$key + 1] == "Skills Review") {
                            $response["Grammar and Syntax(2)"] = null;
                        } elseif (array_key_exists("Grammar and Syntax", $response)) {
                            $response["Grammar and Syntax(2)"] = $parsed[$key + 1];
                        } else {
                            $response["Grammar and Syntax"] = $parsed[$key + 1];
                        }
                        break;
                    default:
                        break;
                }
            }
            $response["Overall Score"] = $parsed[4];
            $response["Terminology Score"] = $parsed[5];
            $response["Accuracy Score"] = $parsed[6];
            $response["File"] = $file["name"];
            $data[] = $response;
        }
        $html = view('components.parsedItemPDF')->with(['data' => $data])->render();
        return response()->json(["html" => $html]);
    }
}
