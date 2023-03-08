@extends('dashboard.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Customers</h4>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<!-- end page title -->

<div class="row" style="min-height: 100vh">
    <div class="col-sm-12">
        <div class="page-content-box" id='map' style="">


        </div>
    </div>
    <div class="clearfix"></div>
</div> <!-- /end of page content -->
@endsection

@section('style')
<style type="text/css">
    :root {
        --color-brand--1: #ffb545;
        --color-brand--2: #00c46a;

        --color-dark--1: #2d3439;
        --color-dark--2: #42484d;
        --color-light--1: #aaa;
        --color-light--2: #ececec;
        --color-light--3: rgb(214, 222, 224);
    }

    /* MAP */
    #map {
        flex: 1;
        height: 100%;
        background-color: var(--color-light--1);
    }

    /* Popup width is defined in JS using options */
    .leaflet-popup .leaflet-popup-content-wrapper {
        background-color: var(--color-dark--1);
        color: var(--color-light--2);
        border-radius: 5px;
        padding-right: 0.6rem;
    }

    .leaflet-popup .leaflet-popup-content {
        font-size: 1.5rem;
    }

    .leaflet-popup .leaflet-popup-tip {
        background-color: var(--color-dark--1);
    }

    .running-popup .leaflet-popup-content-wrapper {
        border-left: 5px solid var(--color-brand--2);
    }

    .cycling-popup .leaflet-popup-content-wrapper {
        border-left: 5px solid var(--color-brand--1);
    }
</style>
@endsection

@section('script')

<script>
    const customers = @json($customers);
    const { latitiude, longitude } = customers[0];
    const initCoords = [latitiude, longitude];
    const map = L.map('map').setView(initCoords, 10);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    customers.forEach(function(customer) {
        const {full_name, latitiude, longitude } = customer;
        const coords = [latitiude, longitude];
        if(latitiude && longitude){
            L.marker(coords).addTo(map)
            .bindPopup(L.popup({
                autoPan: false,
                autoClose:true,
                content:full_name
            }))
            // .openPopup();
        }

    });


</script>

<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAEUCE-Q7H2alF5xMLT2CWGoIJiuwWZpR4&callback=myMap"></script> -->
@endsection