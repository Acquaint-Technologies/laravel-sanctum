@extends('sanctum::layouts.mail')

@section('content')
<!-- Two Columns -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
    <tr>
        <td class="p30-15" style="padding: 50px 30px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="section-inner">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <th class="column-top" width="100%" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td class="text-title pb10" style="color:#000000; font-family:'Noto Serif', Georgia, serif; font-size:22px; line-height:32px; text-align:left; padding-bottom:10px;">Hi {{ $data->name }},</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text2 pb15" style="color:#585858; font-family:'Raleway', Arial,sans-serif; font-size:12px; line-height:20px; text-align:left; padding-bottom:15px;">You are receiving this email because we received a password reset request for your account</td>
                                                    </tr>
                                                    <!-- Button -->
                                                    <tr>
                                                        <td align="center" style=" padding-bottom:10px;">
                                                            <table width="140" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <td class="text-button black-button" style="font-family:'Raleway', Arial,sans-serif; font-size:14px; line-height:18px; text-align:center; text-transform:uppercase; padding:10px; background:transparent !important; border:1px solid #000000; color:#000000;"><a target="_blank" class="link-black" style="color:#000001; text-decoration:none;"><span class="link-black" style="color:#000001; text-decoration:none;">{{ $data->token }}</span></a></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <!-- END Button -->

                                                    <tr>
                                                        <td class="text2 pb15" style="color:#585858; font-family:'Raleway', Arial,sans-serif; font-size:12px; line-height:20px; text-align:left; padding-bottom:15px;">If you did not request a password reset, no further action is required.</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text2 pb15" style="color:#585858; font-family:'Raleway', Arial,sans-serif; font-size:12px; line-height:20px; text-align:left; padding-bottom:15px;">Regards<br>{{ env('APP_NAME') }}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </th>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!-- END Two Columns -->
@endsection
