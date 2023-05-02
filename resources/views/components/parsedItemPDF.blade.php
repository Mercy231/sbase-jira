@foreach($data as $item)
    <hr>
    <h5>{{ $item["File"] }}</h5>
    <ul>
        <li>Candidate Name: {{ $item["Candidate Name"] }}</li>
        <li>Test Date: {{ $item["Test Date"] }}</li>
        <li>Overall Score: {{ $item["Overall Score"] }}</li>
        <li>Terminology Score: {{ $item["Terminology Score"] }}</li>
        <li>Accuracy Score: {{ $item["Accuracy Score"] }}</li>
        <li>Grade: {{ $item["Grade"] }}</li>
        <li>Source: {{ $item["Source"] }}</li>
        <li>Accent/Pron: {{ $item["Accent/Pron"] }}</li>
        <li>Grammar and Syntax: {{ $item["Grammar and Syntax"] }}</li>
        <li>Target: {{ $item["Target"] }}</li>
        <li>Accent/Pron: {{ $item["Accent/Pron(2)"] }}</li>
        <li>Grammar and Syntax: {{ $item["Grammar and Syntax(2)"] }}</li>
    </ul>
@endforeach
