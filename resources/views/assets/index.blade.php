@extends('layouts.admin')

@section('content')
    <style>
        .canvas-container {
            position: relative;
            width: 100%;
            border: 1px solid #ddd;
            margin-top: 20px;
        }

        .toolbar {
            margin-bottom: 20px;
        }

        .toolbar button,
        .toolbar input,
        .toolbar select {
            margin-right: 5px;
        }

        .border {
            border: 1px solid #ccc;
        }
    </style>
    <div class="container mt-5">
        <div class="row">
            <div class="d-flex align-items-center justify-content-between col-6">
                <input type="text" class="form-control me-2" id="inputSite" name="site" placeholder="Masukkan Nama Site"
                    value="{{ old('site') ? old('site') : $site ?? '' }}">
            </div>

            <div class="col-md-12">
                <div class="mb-3">
                    <input type="file" id="file" class="btn btn-light">
                    <button id="clear-canvas" class="btn btn-danger"><i class="fa fa-trash"></i> Clear</button>
                    <button id="add-text" class="btn btn-info"><i class="fa fa-font"></i> Teks</button>
                    <select id="font-family" class="btn btn-light">
                        <option value="Arial">Arial</option>
                        <option value="Helvetica">Helvetica</option>
                        <option value="Times New Roman">Times New Roman</option>
                    </select>
                    <input type="color" id="text-color" class="btn btn-light">
                    <button id="draw-line" class="btn btn-primary"><i class="fa fa-pencil-alt"></i> Garis</button>
                    <button id="add-rect" class="btn btn-secondary"><i class="far fa-square"></i> Persegi</button>
                    <button id="add-circle" class="btn btn-warning"><i class="far fa-circle"></i> Lingkaran</button>
                    <button id="add-arrow" class="btn btn-primary"><i class="fas fa-arrow-up"></i> Panah</button>
                    <button id="add-triangle" class="btn btn-success"><i class="fas fa-play"></i> Segitiga</button>
                    <button id="group-objects" class="btn btn-dark"><i class="fas fa-object-group"></i> Group</button>
                    <button id="ungroup-objects" class="btn btn-info"><i class="fas fa-object-ungroup"></i> Ungroup</button>
                    <input type="color" id="canvas-bg" class="btn btn-light" value="#ffffff"
                        title="Ubah Warna Background">
                    <input type="color" id="object-color" class="btn btn-light" title="Ubah Warna Objek">
                    <button id="delete-object" class="btn btn-dark"><i class="fas fa-eraser"></i> Hapus Objek</button>
                    <button id="save-canvas" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                </div>
                <canvas id="canvas" width="1100" height="600" class="border"></canvas>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.5.0/fabric.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var canvas = new fabric.Canvas('canvas', {
                preserveObjectStacking: true
            });
            var canvasData = @json(isset($asset) && !empty($asset->canvasData) ? $asset->canvasData : null);
            canvas.backgroundColor = '#ffffff';
            canvas.renderAll();

            function resetCanvasEvents() {
                canvas.isDrawingMode = false;
                canvas.selection = true;
                canvas.forEachObject(function(o) {
                    o.selectable = true;
                    o.evented = true;
                });
                canvas.off('mouse:down');
                canvas.off('mouse:move');
                canvas.off('mouse:up');
            }

            function addEventListeners() {
                document.getElementById('file').addEventListener('change', function(e) {
                    var file = e.target.files[0];
                    if (file) {
                        var reader = new FileReader();
                        reader.onload = function(f) {
                            var data = f.target.result;
                            fabric.Image.fromURL(data, function(img) {
                                var oImg = img.set({
                                    left: 0,
                                    top: 0,
                                    angle: 0
                                }).scale(0.9);
                                canvas.add(oImg).renderAll();
                                var a = canvas.setActiveObject(oImg);
                                var dataURL = canvas.toDataURL({
                                    format: 'png',
                                    quality: 0.8
                                });
                            });
                        };
                        reader.readAsDataURL(file);
                    }
                });

                document.getElementById('clear-canvas').addEventListener('click', function() {
                    canvas.clear();
                    canvas.backgroundColor = '#ffffff';
                    canvas.renderAll();
                });

                document.getElementById('add-text').addEventListener('click', function() {
                    resetCanvasEvents();
                    var text = new fabric.IText('Tulis teks di sini...', {
                        left: 50,
                        top: 100,
                        fontFamily: 'Arial',
                        fill: document.getElementById('text-color').value
                    });
                    canvas.add(text);
                });

                document.getElementById('font-family').addEventListener('change', function() {
                    var fontFamily = this.value;
                    var object = canvas.getActiveObject();
                    if (object && object.type === 'i-text') {
                        object.set('fontFamily', fontFamily);
                        canvas.renderAll();
                    }
                });

                document.getElementById('text-color').addEventListener('change', function() {
                    var color = this.value;
                    var object = canvas.getActiveObject();
                    if (object && (object.type === 'i-text' || object.type === 'text')) {
                        object.set('fill', color);
                        canvas.renderAll();
                    }
                });
                document.getElementById('draw-line').addEventListener('click', function() {
                    resetCanvasEvents();
                    var line, isDown;
                    canvas.on('mouse:down', function(o) {
                        isDown = true;
                        var pointer = canvas.getPointer(o.e);
                        var points = [pointer.x, pointer.y, pointer.x, pointer.y];
                        line = new fabric.Line(points, {
                            strokeWidth: 2,
                            fill: 'red',
                            stroke: 'red',
                            originX: 'center',
                            originY: 'center'
                        });
                        canvas.add(line);
                    });
                    canvas.on('mouse:move', function(o) {
                        if (!isDown) return;
                        var pointer = canvas.getPointer(o.e);
                        line.set({
                            x2: pointer.x,
                            y2: pointer.y
                        });
                        canvas.renderAll();
                    });

                    canvas.on('mouse:up', function(o) {
                        isDown = false;
                    });
                });
                document.getElementById('add-rect').addEventListener('click', function() {
                    resetCanvasEvents();
                    var rect = new fabric.Rect({
                        left: 100,
                        top: 100,
                        fill: 'yellow',
                        width: 60,
                        height: 70,
                        angle: 0
                    });
                    canvas.add(rect);
                });

                document.getElementById('add-circle').addEventListener('click', function() {
                    resetCanvasEvents();
                    var circle = new fabric.Circle({
                        radius: 30,
                        fill: 'green',
                        left: 100,
                        top: 100
                    });
                    canvas.add(circle);
                });

                document.getElementById('add-arrow').addEventListener('click', function() {
                    resetCanvasEvents();
                    var startX = 50,
                        startY = 100,
                        endX = 200,
                        endY = 100;
                    var angle = Math.atan2(endY - startY, endX - startX);

                    var line = new fabric.Line([startX, startY, endX, endY], {
                        strokeWidth: 3,
                        stroke: 'black',
                    });


                    var arrowLength = 20;
                    var arrowWidth = 20;
                    var triangle = new fabric.Triangle({
                        left: endX,
                        top: endY,
                        originX: 'center',
                        originY: 'center',
                        width: arrowWidth,
                        height: arrowLength,
                        fill: 'black',
                        angle: (angle * 180 / Math.PI) +
                            90
                    });

                    var group = new fabric.Group([line, triangle], {
                        selectable: true,
                    });

                    canvas.add(group);
                });
                document.getElementById('add-triangle').addEventListener('click', function() {
                    resetCanvasEvents();
                    var triangle = new fabric.Triangle({
                        width: 20,
                        height: 30,
                        fill: 'blue',
                        left: 50,
                        top: 50
                    });
                    canvas.add(triangle);
                });

                document.getElementById('group-objects').addEventListener('click', function() {
                    if (!canvas.getActiveObject()) {
                        return;
                    }
                    if (canvas.getActiveObject().type !== 'activeSelection') {
                        return;
                    }
                    canvas.getActiveObject().toGroup();
                    canvas.requestRenderAll();
                });

                document.getElementById('ungroup-objects').addEventListener('click', function() {
                    if (!canvas.getActiveObject()) {
                        return;
                    }
                    if (canvas.getActiveObject().type !== 'group') {
                        return;
                    }
                    canvas.getActiveObject().toActiveSelection();
                    canvas.requestRenderAll();
                });

                document.getElementById('save-canvas').addEventListener('click', function() {
                    const site = document.getElementById('inputSite').value;
                    const jsonCanvas = JSON.stringify(canvas.toJSON());
                    const dataURL = canvas.toDataURL({
                        format: 'png',
                        quality: 0.8
                    });
                    console.log(dataURL);
                    fetch('{{ route('asset.store') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                image: dataURL,
                                canvas: jsonCanvas, // Kirim sebagai JSON
                                site: site
                            })
                        })
                        .then(response => response.json())
                        .then(data => console.log('Success:', data))
                        .catch((error) => console.error('Error:', error));
                });


                document.getElementById('canvas-bg').addEventListener('change', function() {
                    canvas.backgroundColor = this.value;
                    canvas.renderAll();
                });

                document.getElementById('object-color').addEventListener('change', function() {
                    var selectedObject = canvas.getActiveObject();
                    if (selectedObject) {
                        if (selectedObject.type === 'line' || selectedObject.type === 'circle' ||
                            selectedObject.type === 'rect' || selectedObject.type === 'triangle') {
                            selectedObject.set({
                                fill: this.value
                            });
                            canvas.renderAll();
                        }
                    }
                });

                document.getElementById('delete-object').addEventListener('click', function() {
                    var selectedObject = canvas.getActiveObject();
                    if (selectedObject) {
                        canvas.remove(selectedObject);
                    }
                });
            }

            function loadSavedCanvas() {
                if (canvasData) {
                    canvas.loadFromJSON(canvasData, function() {
                        canvas.renderAll();
                        // Setelah canvas di-render, loop melalui semua objek
                        canvas.getObjects().forEach(function(obj) {
                            if (obj.type === 'image' && obj._element === null) {
                                // Pastikan URL atau src dalam objek gambar valid
                                fabric.Image.fromURL(obj.src, function(img) {
                                    obj.setElement(img.getElement());
                                    canvas.renderAll();
                                });
                            }

                        });
                    });
                }

            }
            loadSavedCanvas();
            addEventListeners();
        });
    </script>
@endpush
