@extends('platform::dashboard')

@section('title', 'Import Products')

@push('head')
    {{-- import pluplad for turbo also in config/platform.php --}}
    <script src="{{ asset('assets/admin/js/plupload.full.min.js') }}" type="text/javascript"></script>

    <script type="application/javascript">
        let uploaderZip, uploaderXls;

        document.addEventListener('turbo:load', () => {
            uploaderZip = new plupload.Uploader({
                runtimes: 'html5,html4',
                chunk_size: '2mb',
                browse_button: 'browseZip',
//                container: 'filelist',
                url: '{{ route('platform.import.uploadchunked') }}',
                filters: {
                    max_file_size: '2000mb',
                    mime_types: [
                        {title: "Image files", extensions: "jpg,jpeg,gif,png"},
                        {title: "Zip files", extensions: "zip"}
                    ]
                },
                init: {
                    PostInit: function () {
                        //document.getElementById('filelistZip').innerHTML = '';
                        document.getElementById('uploadZip').onclick = function () {
                            if (uploaderZip.files.length === 0) {
                                document.getElementById('importzipStatus').innerHTML = '<span style="color:red">zip file not selected</span>'
                                return false
                            }
                            uploaderZip.start();
                            return false;
                        };
                    },
                    FilesAdded: function (up, files) {
                        plupload.each(files, function (file) {
                            document.getElementById('filelistZip').innerHTML = '<span id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></span>';
                        });
                    },
                    UploadProgress: function (up, file) {
                        document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
                    },
                    FileUploaded: function (up, file, info) {
                        const data = JSON.parse(info.response);
                        axios.post(
                            '{{ route('platform.import.zip') }}',
                            {
                                filename: data.info.path,
                            })
                            .then(function (response) {
                                updateZipImportProgress(response.data.task_id);
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                        //console.log('[FileUploaded] Zip File:', file, "Info:", info);
                    },

                    Error: function (up, err) {
                        console.log("File upload error #" + err.code + ": " + err.message);
                    },
                },
            })
            uploaderZip.init();


            uploaderXls = new plupload.Uploader({
                runtimes: 'html5,html4',
                chunk_size: '2mb',
                browse_button: 'browseXls',
                url: '{{ route('platform.import.uploadxls') }}',
                filters: {
                    max_file_size: '10mb',
                    mime_types: [
                        {title: "Excel spreadsheets", extensions: "xls,xlsx,application/vnd.ms-excel"},
                    ]
                },
                init: {
                    PostInit: function () {
                        document.getElementById('uploadXls').onclick = function () {
                            if (uploaderXls.files.length === 0) {
                                document.getElementById('importxlsStatus').innerHTML = '<span style="color:red">datasheet file not selected</span>'
                                return false;
                            }
                            uploaderXls.start();
                            return false;
                        };
                    },
                    FilesAdded: function (up, files) {
                        plupload.each(files, function (file) {
                            document.getElementById('filelistXls').innerHTML = '<span id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></span>';
                        });
                    },
                    UploadProgress: function (up, file) {
                        document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
                    },
                    FileUploaded: function (up, file, info) {
                        // Called when file has finished uploading
                        const data = JSON.parse(info.response);
                        //console.log('[FileUploaded] File:', file, "Info:", info);

                        axios.post(
                            '{{ route('platform.import.xls') }}',
                            {
                                filename: data.info.path,
                                autopublish: document.getElementById('autopublish').hasAttribute('checked'),
                            }
                        )
                        .then(function (response) {
                            //console.log(response)
                            updateXlsImportProgress(response.data.task_id);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    },
                    Error: function (up, err) {
                        console.log("File upload error #" + err.code + ": " + err.message);
                    }
                    ,
                },
            })
            uploaderXls.init();


            // =========== flush buttons ==========

            document.getElementById('flush-products')?.addEventListener('click', (e)=>{
                if (!confirm('Do you really want flush ALL products ?')) {
                    return false;
                }
            });

            document.getElementById('flush-categories')?.addEventListener('click', (e)=>{
                if (!confirm('Do you really want flush ALL categories and products ?')) {
                    return false;
                }
            });

            document.getElementById('flush-manufactures')?.addEventListener('click', (e)=>{
                if (!confirm('Do you really want flush \r\nALL manufacturers with categories and products?')) {
                    return false;
                }
            });


        });

        function updateXlsImportProgress(id) {
            let timerImportXls = setTimeout(function(){
                let error, completed = false;
                axios.get("{{ route('platform.import.statusxls') }}",
                    {
                        params: {'task_id': id},
                    }
                ).then(function (response) {
                    document.getElementById('importxlsStatus').innerText = ('[' + response.data.status +'] '
                        + ((response.data.task_message === undefined || response.data.task_message === null) ? '' : response.data.task_message)
                    );
                    document.getElementById('importxlsLog').classList.remove('d-none');
                    document.getElementById('importxlsLog').href = '/admin/service/task/' + id + '/log';

                    completed = response.data.status === 'finished';
                    if (completed) {
                        uploaderXls.state = plupload.DONE;
                        uploaderXls.files.clean();
                    }
                }).catch(function(err) {
                    error = err;
                    uploaderXls.state = plupload.DONE
                });

                if (error || completed) {
                    clearInterval(timerImportXls)
                }
                }, 2000
            );
        }

        function updateZipImportProgress(id) {
            let timerImportXls = setTimeout(function(){
                    let error, completed = false;
                    axios.get("{{ route('platform.import.statuszip') }}",
                        {
                            params: {'task_id': id},
                        }
                    ).then(function (response) {
                        document.getElementById('importzipStatus').innerText = '[' + response.data.status +'] ' +
                            ((response.data.task_message === undefined || response.data.task_message === null) ? '' : response.data.task_message);
                        document.getElementById('importzipLog').classList.remove('d-none');
                        document.getElementById('importzipLog').href = '/admin/service/task/' + id + '/log';
                        completed = response.data.status === 'finished';
                        if (completed) {
                            uploaderZip.state = plupload.DONE;
                            uploaderZip.files.clean();
                        }
                    }).catch(function(err) {
                        uploaderZip.state = plupload.FAILED;
                        error = err;
                    });

                    if (error || completed) {
                        clearInterval(timerImportXls)
                    }
                }, 2000
            );
        }

    </script>
@endpush

@section('content')
    <div data-controller="tabs" data-tabs-slug=""
         data-tabs-active-tab="#tab-import-xls">
        <ul class="nav nav-tabs nav-tabs-scroll-bar" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" data-action="tabs#setActiveTab" data-bs-target="#tab-import-xls"
                   id="button-tab-import-xls" aria-selected="true" role="tab" data-bs-toggle="tab">
                    Import Products
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" data-action="tabs#setActiveTab" data-bs-target="#tab-import-images"
                   id="button-tab-import-images" aria-selected="false" role="tab" data-bs-toggle="tab" tabindex="-1">
                    Import Images & Documents
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" data-action="tabs#setActiveTab" data-bs-target="#tab-import-service"
                   id="button-tab-import-service" aria-selected="false" role="tab" data-bs-toggle="tab" tabindex="-1">
                    Service
                </a>
            </li>
        </ul>
    </div>
    <section class="mb-3">
        <div class="no-border-xs">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active show" id="tab-import-xls"
                     aria-labelledby="#button-tab-import-xls">
                    <fieldset class="mb-3">
                        <div class="bg-white rounded shadow-sm p-4 py-4 d-flex flex-column">
                            <div class="my-1">
                                If problems with file format, try
                                <a class="link-info" href="{{asset('assets/admin/xls/etrade-import-example.xlsx')}}">example
                                    file</a>
                            </div>

                            <div class="d2-grid py-3 border-top">
                                <dt class="text-muted fw-normal">
                                    <button class="btn btn-default" id="browseXls">Selected
                                        spreadsheet file (xls, xlsx)
                                    </button>
                                </dt>
                                <dd class="text-black" id="filelistXls">
                                    none selected
                                </dd>
                            </div>
                            <div class="form-group">
                                <div class="form-check form-switch">
                                    <input value="1" type="checkbox" class="form-check-input" novalue="0" yesvalue="1"
                                           name="page[is_active]" title="Active" id="autopublish" checked="">
                                    <label class="form-check-label" for="autopublish">Publish new
                                        elements(Manufacturers, Categories, Products)</label>
                                </div>
                            </div>
                            <div class="form-group my-4">
                                <button class="btn btn-default  d-inline" id="uploadXls">Import data</button>
                                <a id="importxlsLog" class="btn btn-link d-inline d-none" href="#">download log</a>
                            </div>
                            <div class="fw-bold">
                                Status: <span id="importxlsStatus"></span>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div role="tabpanel" class="tab-pane" id="tab-import-images"
                     aria-labelledby="#button-tab-import-images">
                    <fieldset class="mb-3">
                        <div class="bg-white rounded shadow-sm p-4 py-4 d-flex flex-column">

                            <div class="my-1">
                                Images and documents files should have the same names as products SKU,<br>
                                files may be located in any folders (sorted by manufacturers and categories or not)
                            </div>


                            <div class="d2-grid py-3 border-top">
                                <dt class="text-muted fw-normal">
                                    <button id="browseZip" class="btn btn-default">Select Zip file</button>
                                </dt>
                                <dd class="text-black" id="filelistZip">
                                    none selected
                                </dd>
                            </div>
                            <div class="form-group">
                                <button id="uploadZip" class="btn btn-default d-inline">Upload & process images</button>
                                <a id="importzipLog" class="m-0 btn btn-link d-inline d-none" href="#" >download log</a>
                            </div>
                            <div class="fw-bold">
                                Status: <span id="importzipStatus"></span>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div role="tabpanel" class="tab-pane" id="tab-import-service"
                     aria-labelledby="#button-tab-import-service">
                    <fieldset class="mb-3">
                        <div class="bg-white rounded shadow-sm p-4 py-4 d-flex flex-column">

                            <div class="my-1">
                                <span style="color: red">Images and documents</span> will also be removed !!!
                            </div>

                            <div class="py-3 border-top">
                                <div class="my-2 text-muted fw-normal  form-group row ">
                                    <label for="flush-products" class="col-sm-4 col-form-label">Delete all products</label>
                                    <div class="col-sm-3">
                                        <button id="flush-products" class="btn btn-default">Flush products data...</button>
                                    </div>
                                </div>
                                <div class="my-2 text-muted fw-normal  form-group row ">
                                    <label for="flush-categories" class="col-sm-4 col-form-label">Delete all categories and products</label>
                                    <div class="col-sm-3">
                                        <button id="flush-categories" class="btn btn-default">Flush categories data...</button>
                                    </div>
                                </div>
                                <div class="my-2 text-muted fw-normal  form-group row ">
                                    <label for="flush-manufactures" class="col-sm-4 col-form-label">Delete all manufacturers, categories and products</label>
                                    <div class="col-sm-3">
                                        <button id="flush-manufactures" class="btn btn-default">Flush manufactures data...</button>
                                    </div>
                                </div>
                            </div>

                            <div class="fw-bold">
                                Status: <span id="flushStatus"></span>
                            </div>

                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </section>
    <input class="d-none" id="screen-state" value="">
@stop