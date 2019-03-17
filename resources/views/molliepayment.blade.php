<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form method="post" action="/submit">
        @csrf
        Select your bank:
        <select name="issuer">
            {{--@csrf {{ csrf_field() }} --}}

            <option value="">or select later</option>
            @foreach ($method->issuers() as $issuer)
                <option id="bank" value='{{$issuer->id}}'>{{$issuer->name}}</option>
            @endforeach
        </select>
        <button>OK</button>
    </form>
</body>
</html>