<h1>{{ isset( $viewData) ? $viewData['data']['message'] : 'NA' }}</h1>
@php
    if(isset($viewData))
    {
        echo"<pre>";
            print_r($viewData);
        echo"<pre>";
    }
@endphp
