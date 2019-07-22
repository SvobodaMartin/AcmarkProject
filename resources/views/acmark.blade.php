@extends('layout.main')

@section('content')

<section class="content">
    <div class="container ">
        <div class="row">
            <div class="col-sm-12">
                <div class="content">
                    <div class="title text-center m-b-md">

                        {{$title}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container pt-5">
        <div class="row">
            <div class="col-sm-12">
                <form method="GET" action="/">
                    {{--@csrf--}}
                    <label for="ico">Zadejte hledané IČO</label>
                    <input type="text" name="ico" id="myTextBox" placeholder="{{isset($_GET['ico'])?'současný:' . $_GET['ico']:"IČO"}}">
                    <button type="submit" class="btn-primary">Vyhledat záznam</button>
                    <br>
                    <p><small>vzor: 27074358</small><br>
                    <a class="" href="http://wwwinfo.mfcr.cz/cgi-bin/ares/darv_bas.cgi?ico=27074358" target="_blank"><small>src</small></a></p>
                </form>
            </div>
        </div>
    </div>
    <div class="container pt-5">
        <div class="row">
            <div class="col-sm-12">
                <table class="table">
                    @if($srcIco != null)
                        <tr>
                            <td>
                                IČO:
                            </td>
                            <td>{{$srcIco}}</td>
                        </tr>
                    @endif
                    @if($srcName != null)
                        <tr>
                            <td>
                                Jméno společnosti:
                            </td>
                            <td>{{$srcName}}</td>
                        </tr>
                    @endif

                    @if($activityCode != null)
                        <tr class="mt-4" >
                            <td colspan="2" style="border-top: 0">
                                <h4>Činnosti společnosti:</h4>
                            </td>
                        </tr>

                        @foreach ($activityCode as $key => $code)
                            @if($key >= 5)
                                <tr class="hidden ">
                                    <td>kód činnosti:</td>
                                    <td>{{$code}}</td>
                                </tr>
                                <tr class="hidden border-t-0">
                                    <td>Popis činnosti:</td>
                                    <td>{{$activityDsc[$key]}}</td>
                                </tr>
                            @else
                                <tr class="mt-4 ">
                                    <td>kód činnosti:</td>
                                    <td>{{$code}}</td>
                                </tr>
                                <tr class="border-t-0">
                                    <td>Popis činnosti:</td>
                                    <td>{{$activityDsc[$key]}}</td>
                                </tr>
                            @endif
                            @if($key == 5)
                                <tr class="showBtn">
                                    <td colspan="2">
                                        <a class="showMore btn-primary " style="cursor: pointer">Zobrazit více činností</a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script>
        (function($) {
            $.fn.inputFilter = function(inputFilter) {
                return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
                    if (inputFilter(this.value)) {
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    }
                });
            };
        }(jQuery));


        $(document).ready(function() {
            // Restrict input to digits by using a regular expression filter.
            $("#myTextBox").inputFilter(function(value) {
                return /^\d*$/.test(value);
            });
        });
        $(document).ready(function() {

            $(document).ready(function () {
                $(".showMore").click(function () {
                    $("tr.hidden").removeClass('hidden')
                    $("tr.showBtn").addClass('hidden')
                })
            })
        });
    </script>
@endpush