@extends('layouts.admin')

@section('content')
    <style>
        #map {
            height: 380px;
        }
    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    {{-- <div class="card-header">{{ __('Dashboard') }}</div> --}}

                    <div class="card-body">
                        <div id="map"></div>
                        <div>
                            <ul>
                                <li><img src="{{ asset('assets/marker/black.png') }}" width="20px"><small>. Customer
                                        Perusahaan</small></li>
                                <li><img src="{{ asset('assets/marker/green.png') }}" width="12px"><small>. Customer
                                        Perumahan</small></li>
                                <li><img src="{{ asset('assets/marker/red.png') }}" width="14px"><small>. Customer
                                        Site</small></li>


                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" rel="stylesheet" />
    <script>
        var map = L.map('map').setView([-6.4043810871534355, 106.87004348081192], 15);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var blackIcon = L.icon({
            iconUrl: 'assets/marker/black.png',
            iconSize: [12, 20], // size of the icon
            iconAnchor: [6, 20], // point of the icon which will correspond to marker's location
            popupAnchor: [0, -20] // point from which the popup should open relative to the iconAnchor
        });

        var greenIcon = L.icon({
            iconUrl: 'assets/marker/green.png',
            iconSize: [12, 20], // size of the icon
            iconAnchor: [6, 20], // point of the icon which will correspond to marker's location
            popupAnchor: [0, -20] // point from which the popup should open relative to the iconAnchor
        });
        var redIcon = L.icon({
            iconUrl: 'assets/marker/red.png',
            iconSize: [12, 20], // size of the icon
            iconAnchor: [6, 20], // point of the icon which will correspond to marker's location
            popupAnchor: [0, -20] // point from which the popup should open relative to the iconAnchor
        });

        //black markers
        var blackMarkers = [
            [-6.401282100644635, 106.86994990386715],
            [-6.4016513349379265, 106.86986715840095],
            [-6.40189332922461, 106.86963648201377],
            [-6.402386731083103, 106.8694078412942],
            [-6.402969975548593, 106.86924197678343],


        ];
        blackMarkers.forEach(function(point) {
            L.marker(point, {
                icon: blackIcon
            }).addTo(map);
        });

        //green markers
        var greenMarkers = [
            [-6.407474037336285, 106.86832805256157],
            [-6.407594488851647, 106.86892771656207],
            [-6.406681592447343, 106.86921478975381],
            [-6.406034956506123, 106.86936789545604],
            [-6.406230914886554, 106.87008962947885],
            [-6.406470374820399, 106.87039154875188],

        ];
        greenMarkers.forEach(function(point) {
            L.marker(point, {
                icon: greenIcon
            }).addTo(map);
        });

        //red markers
        var redMarkers = [
            [-6.401587756567166, 106.87396439556156],
            [-6.401944931442587, 106.87405559067153],
            [-6.402307437021314, 106.87470468527478],
            [-6.403133735517512, 106.87445792203876],
            [-6.4039580944211885, 106.87448328056252],
            [-6.405027755715378, 106.8745401126674],
            [-6.405484205600966, 106.87443804219924],
            [-6.405408130648375, 106.87391493104987],
            [-6.405801184447994, 106.87380010177318],
            [-6.405725109542654, 106.87314940253859],
            [-6.405344734845896, 106.87251146211253],
            [-6.405040434884381, 106.8724349092614],
        ];
        redMarkers.forEach(function(point) {
            L.marker(point, {
                icon: redIcon
            }).addTo(map);
        });


        // Drawing polylines
        var blackLine = L.polyline(blackMarkers, {
            color: 'green'
        }).addTo(map);
        var greenLine = L.polyline(greenMarkers, {
            color: 'green'
        }).addTo(map);
        var redLine = L.polyline(redMarkers, {
            color: 'green'
        }).addTo(map);


        // Optionally, fit map bounds to show all markers and polylines
        var group = new L.featureGroup([blackLine, greenLine, redLine]);
        map.fitBounds(group.getBounds());

        var pathPoints = [

            [-6.406230914886554, 106.87008962947885],
            [-6.406470374820399, 106.87039154875188],
            [-6.407044166587772, 106.87060807290715],
            [-6.407097959531331, 106.87079753154768],
            [-6.406999339130471, 106.87086970626788],
            [-6.406577960839345, 106.8708787281079],
            [-6.406398650822683, 106.87109525226852],
            [-6.40617451320501, 106.87127568906466],
            [-6.405582789443119, 106.87145612586517],
            [-6.405340720433692, 106.87163656266567],
            [-6.405179341030285, 106.87192526154645],
            [-6.4051788692842955, 106.87192655910764],
            [-6.405040434884381, 106.8724349092614],
            // Tambahkan lebih banyak titik sesuai kebutuhan
        ];
        var path2Points = [

            [-6.407454894537179, 106.86831015450299],
            [-6.404213691820096, 106.86925429210166],
            [-6.40353221951535, 106.86940760551637],
            [-6.403499800494956, 106.86933046046761],
            [-6.403041338597384, 106.8694538420856],
            [-6.402969975548593, 106.86924197678343],

        ];
        var pathredPoints = [

            [-6.401764793845812, 106.87751429111849],
            [-6.401840185112971, 106.87491973105428],
            [-6.401327524276796, 106.87312933288135],
            [-6.401010880562066, 106.87291691275914],
            [-6.401101350214882, 106.87190033074567],
            [-6.401297367740997, 106.86983682098703],
            [-6.400633923481131, 106.86900231337263],

        ];
        var pathgreenPoints = [
            [-6.401657104481575, 106.86986426758016],
            [-6.401745859243947, 106.87009392613353],
            [-6.402247297741571, 106.87004924111783],
            [-6.402292532460464, 106.87047408136225],
            [-6.402850426997259, 106.87042856276463],
            [-6.403455536299501, 106.87016384134498],
            [-6.403734478803924, 106.87078902296251],
            [-6.4038866291966325, 106.8712100636437],
            [-6.40420360903579, 106.87112075198405],
            [-6.404406476029562, 106.87267732662366],
            [-6.404533267859732, 106.8727666382833],
            [-6.404710776369041, 106.87317492015598],

            [-6.403493573922712, 106.8733152670497],
            [-6.402961046939847, 106.87311112611339],
            [-6.402821575495397, 106.87387665462465],
            [-6.401959387538585, 106.87386389581613],
            [-6.4019340290472275, 106.8740297603269],

        ];


        // Menggambar garis berdasarkan titik-titik
        var polyline = L.polyline(pathPoints, {
            color: 'green'
        }).addTo(map);
        var polyline2 = L.polyline(path2Points, {
            color: 'green'
        }).addTo(map);
        var polyline3 = L.polyline(pathredPoints, {
            color: 'red'
        }).addTo(map);
        var polyline4 = L.polyline(pathgreenPoints, {
            color: 'green'
        }).addTo(map);

        // Fit map bounds untuk menampilkan semua garis
        map.fitBounds(polyline.getBounds());
        map.fitBounds(polyline2.getBounds());
        map.fitBounds(polyline3.getBounds());
        map.fitBounds(polyline4.getBounds());
    </script>
@endpush
