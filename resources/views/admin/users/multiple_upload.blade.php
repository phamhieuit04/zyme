@extends('index')

@section('content')
    <style>
        .hidden {
            visibility: hidden;
        }

        #upload-frame {
            border: 1px solid gray;
        }

        .progress-bar {
            background: gainsboro;
            margin: 15px 50px;
            height: 25px;
        }

        .in-progress {
            width: 10%;
            height: 25px;
            background: #03a9f4;
        }

        .file-success {
            color: #03a9f4;
        }

        .file-failed {
            color: red;
        }

        #list-file {
            height: 400px;
            border: 1px solid gray;
            overflow: auto;
            margin: 0 auto;
            margin-bottom: 15px;
            border-radius: 15px;
        }

        #list-file ul {
            margin-top: 15px;
        }

        #list-file ul li {
            list-style: none;
        }
    </style>
    <div class="container">
        <div class="col-md-12">
            <h2>ユーザーのプロフィール画像を一括で取り込みます。</h2>
        </div>
        <br>
        <div class="col-md-12">
            <form action="#" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="_csrf_token" name="_token" value="{{ csrf_token() }}">
                <label for="chooseFile" class="btn btn-success">
                    ここで画像フォルダを選択してください。
                </label>
                <input type="file" class="hidden" name="files" multiple id="chooseFile">
            </form>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <input type="date" name="date" id="deadline" class="form-control"
                        value="{{ $dateNow->format('Y-m-d') }}">
                </div>
                <div class="col-md-3">
                    <select name="priority" class="form-control" id="priority">
                        <option value="1">LOW</option>
                        <option value="2" selected>MEDIUM</option>
                        <option value="3">HIGH</option>
                    </select>
                </div>
            </div>
        </div>
        <br>
        <div class="col-md-12" id="upload-frame">
            <div class="col-md-11 progress-bar">
                <div class="in-progress"></div>
            </div>
            <br>
            <div class="col-md-11" id="list-file">
                <ul>
                    <li>
                        <p>filename1.png</p>
                    </li>
                    <li>
                        <p>filename2.png</p>
                    </li>
                    <li>
                        <p>filename3.png</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $('#chooseFile').on('change', function (event) {
                let deadline = $('#deadline').val();
                let priority = $('#priority').val();
                let _token = $('#_csrf_token').val();
                let files = event.target.files;
                let listFile = "";

                // Validate files
                for (let i = 0; i < files.length; i++) {
                    let formData = new FormData();
                    console.log(files[i]);
                    if (files[i].type != 'image/jpg' && files[i].type != 'image/png' && files[i].type != 'image/psd' || files[i].size >= 2097152) {
                        listFile += '' + '<li>' + '<p>' + files[i].name + '</p>' + '</li>';
                        $('#list-file ul').append(listFile);
                    }
                }
            })
        });
    </script>
@endsection