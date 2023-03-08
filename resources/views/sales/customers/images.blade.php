@foreach($sale->SalesAttachment as $images)
<div class="col-md-3">
    <figure>
        @php
        $isPDF = str_contains($images->file_name, '.pdf');
        if ($isPDF) {
        $file_path = 'public/uploads/sales/'.$images->file_name;
        $image_path= 'public/uploads/sales/PDF_file.png';
        }else {
        $file_path= 'public/uploads/sales/'.$images->file_name;
        $image_path= 'public/uploads/sales/'.$images->file_name;
        }
        @endphp
        <a href="{{asset($file_path)}}" target="_blank">
            <img src="{{ asset($image_path) }}">
        </a>
        <span id="{{ $images->id }}" class="caption">
            <caption>Remove Image</caption>
        </span>
    </figure>
</div>
@endforeach