<!DOCTYPE html>

<html lang="en" class="no-js">
<!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>Karaoke Menu</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <meta name="MobileOptimized" content="320">
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/bootstrap/css/bootstrapCustom.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/uniform/css/uniform.default.css') }}" rel="stylesheet">
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="{{ asset('assets/plugins/select2/select2_conquer.css') }}" rel="stylesheet">
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME STYLES -->
        <link href="{{ asset('assets/css/style-conquer.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/styleCustom.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/style-responsive.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/themes/default.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/pages/loginWide.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
        <!-- END THEME STYLES -->
        <link rel="shortcut icon" href="favicon.ico"/>
    </head>
    
    <!-- BEGIN BODY -->
    <body class="login">
        <!-- BEGIN LOGO -->
        <div class="logo">
<!--            <img src="assets/img/logo.png" alt=""/>-->
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" action="{{ url('karaokeStart') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <h3 class="form-title hidden-print" style='font-size: 38px;'>Karaoke Menu</h3>
                <ul>
			         @foreach ($errors->all() as $error)
				    <li style='font-size: 16px; color: red'>{{ $error }}</li>
			         @endforeach
                </ul>
                <div class="form-group hidden-print">
                    <label style='font-size: 24px'>Room</label>
                    <select style='font-size: 24px' name="room"class="form-control">
                        
                        @foreach($roomList as $room)
                                <option>{{ $room->id }}</option>
                        @endforeach  
                        
                    </select>
                </div>
                <div class="form-group hidden-print">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-clock-o fa-fw" style="font-size: 2em"></i>
                        </span>
                        <input class="form-control placeholder-no-fix" type="number" style='font-size: 24px;' autocomplete="off" placeholder="Durasi (Menit)" name="durasi"/>
                    </div>
                </div>    
                <div class="form-group hidden-print">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-barcode fa-fw" style="font-size: 2em"></i>
                        </span>
                        <input class="form-control placeholder-no-fix" type="text" style='font-size: 24px;' autocomplete="off" placeholder="No. Kartu" name="noGelang"/>
                    </div>
                </div>
                <div class="form-actions hidden-print">
                    <button type="submit" class="btn btn-info"> 
                        <span class="glyphicon glyphicon-list"></span> List Tagihan
                    </button>
                </div>
                <br>
                <div class="col-md-6 col-md-offset-3">
                    <div id="tagihan">
                        <div>
                            <span>No. Kartu : {{ $noKartu }}</span>
                        </div>
                        <br>
                        <div>
                            <table class="table table-hover" style="width:250px">
                            <tbody>

                                <tr>
                                    <td>
                                        No. Room : {{ $ruang }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        Durasi : {{ $durasi }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        Total : {{ $total }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Saldo Awal : {{ $total + $sisa }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Sisa Saldo : {{ $sisa }}
                                    </td>
                                </tr>
                            
                            
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br>
                <br>
            </form>
            
                <form class="login-form" action="{{ url('karaokePrint') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="kartu" value="{{ $noKartu }}">
                    <input type="hidden" name="harga" value="{{ $total }}">
                <div style="padding-top: 20px"class="form-actions hidden-print">

                    <button type="button" onclick="location.href = '{{ url('cashierMenu') }}';" class="btn btn-primary">
                        <span class="glyphicon glyphicon-chevron-left"></span> Back
                    </button>
                    <button type="submit" class="btn btn-success pull-right" onclick="window.print();">
                        <span class="glyphicon glyphicon-check"></span> Print
                    </button>
                   
                </div>
                    </form>
                    
                    

            <!-- END LOGIN FORM -->
        </div>
        <!-- END LOGIN -->
    </body>
<!-- END BODY -->
</html>