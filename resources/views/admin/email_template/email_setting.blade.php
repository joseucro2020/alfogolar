@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('admin.email-template.setting') }}" method="POST">
                    @csrf
                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="font-weight-bold">Método de Envío</label>
                            </div>
                            <div class="col-md-10">
                                <select name="email_method" class="form-control" >
                                    <option value="php" @if($general_setting->mail_config->name == 'php') selected @endif>
                                        PHP Mail
                                    </option>
                                    <option value="smtp" @if($general_setting->mail_config->name == 'smtp') selected @endif>
                                        SMTP
                                    </option>
                                    <option value="sendgrid" @if($general_setting->mail_config->name == 'sendgrid') selected @endif>
                                        SendGrid API
                                    </option>
                                    <option value="mailjet" @if($general_setting->mail_config->name == 'mailjet') selected @endif>
                                        Mailjet API
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-4 d-none configForm" id="smtp"></div>

                        <div class="mt-4 d-none configForm" id="sendgrid"> </div>

                        <div class="mt-4 d-none configForm" id="mailjet"></div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-block btn--primary mr-2">Modificar</button>
                    </div>
                </form>
            </div><!-- card end -->
        </div>
    </div>


    {{-- TEST MAIL MODAL --}}
    <div id="testMailModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Envío de Correo de Prueba</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('admin.email-template.sendTestMail') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="font-weight-bold" for="mail-to">Para</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" name="email" id="mail-to" class="form-control" placeholder="@lang('Email Address')">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn text--small btn--success">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        "use strict";
        (function ($) {
            var method = $('select[name=email_method]').val();
            config(method);
            $('select[name=email_method]').on('change', function() {
                config($(this).val());
            });

            function config(method){
                $('.configForm').hide('300');
                $('.configForm').html('');

                if(method=='smtp'){
                    $(`#sendgrid`).html('');
                    $(`#mailjet`).html('');
                    $(`#${method}`).html(`<h4 class="border-bottom pb-2 mb-4">Configuración</h4>
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">@lang('Host') (Anfitrión)</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" placeholder="Ejm: smtp.googlemail.com" name="host" value="{{ $general_setting->mail_config->host ?? '' }}" required/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">Puerto</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" placeholder="Puerto Disponible" name="port" value="{{ $general_setting->mail_config->port ?? '' }}" required/>
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold" for="enc">Encriptación</label>
                                </div>
                                <div class="col-md-10">
                                    <select class="custom-select" name="enc" id="enc">
                                        <option null selected>@lang('Select one')</option>
                                        <option value="ssl" {{ @$general_setting->mail_config->enc == 'ssl'?'selected':'' }}>@lang('SSL')</option>
                                        <option value="tls" {{ @$general_setting->mail_config->enc == 'tls'?'selected':'' }}>@lang('TLS')</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">@lang('Username')</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" placeholder="Puede ser tu dirección de correo electrónico" name="username" value="{{ $general_setting->mail_config->username ?? '' }}" required/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">Contraseña</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" placeholder="Puede ser tu contraseña de correo electrónico" name="password" value="{{ $general_setting->mail_config->password ?? '' }}" required/>
                                </div>
                            </div>`)
                    $(`#${method}`).removeClass('d-none').hide().show(300);

                }

                if(method=='sendgrid'){
                    $(`#smtp`).html('');
                    $(`#mailjet`).html('');
                    $(`#${method}`).removeClass('d-none');
                    $(`#${method}`).html(`<h4 class="border-bottom pb-2 mb-4">Configuración</h4>
                                            <div class="form-group row">
                                                <div class="col-md-2">
                                                    <label class="font-weight-bold">APP LLAVE</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" placeholder="App Llave de SendGrid" name="appkey" value="{{ $general_setting->mail_config->appkey ?? '' }}" required/>
                                                </div>
                                            </div>
                                        `);
                    $(`#${method}`).removeClass('d-none').hide().show(300);
                }
                if(method=='mailjet'){
                    $(`#smtp`).html('');
                    $(`#sendgrid`).html('');

                    $(`#${method}`).html(` <h4 class="border-bottom pb-2 mb-4">Configuración</h4>
                                                <div class="form-group row">
                                                    <div class="col-md-2">
                                                        <label class="font-weight-bold">API de Llave Pública</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" placeholder="CLAVE PÚBLICA DE API DE Mailjet" name="public_key" value="{{ $general_setting->mail_config->public_key ?? '' }}" required/>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-2">
                                                        <label class="font-weight-bold">API de Llave Privada</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" placeholder="CLAVE SECRETA DE API DE Mailjet" name="secret_key" value="{{ $general_setting->mail_config->secret_key ?? '' }}" required/>
                                                    </div>
                                                </div>`
                                            );

                    $(`#${method}`).removeClass('d-none').hide().show(300);
                }
            }
        })(jQuery);
    </script>
@endpush


@push('breadcrumb-plugins')
<button type="button" data-target="#testMailModal" data-toggle="modal" class="btn btn-sm btn--primary box--shadow1 text--small">
    @lang('Send Test Mail')
</button>
@endpush
