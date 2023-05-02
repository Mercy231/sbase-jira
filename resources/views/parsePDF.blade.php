@extends('components/layout')

@section('title')
    parsePDF
@endsection

@section('body')
<div>
    <div>
        <label>
            PDF file:
            <input id="fileInputPdf" type="file" name="file" multiple>
        </label>
        <button id="btnSubmitPdf">Submit</button>
    </div>
    <div id="parsedInfo">

    </div>
</div>
@endsection
