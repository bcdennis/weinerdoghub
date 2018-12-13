<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Smile | Your daily dose of joy</title>
</head>
<body>
<table class="body-wrap">
    <tr>
        <td></td>
        <td class="container" width="600">
            <div class="content">
                <table class="main" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="content-wrap">
                            <table  cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                    </td>
                                </tr>
                                @yield('content')
                            </table>
                        </td>
                    </tr>
                </table>
                <div class="footer">
                    <table width="100%">
                        @section('footer')
                        <tr>
                            <td class="aligncenter content-block">
                                Follow us on <a href="https://twitter.com/bitempest" target="_blank">Twitter</a>
                                and <a href="https://www.facebook.com/bitempest" target="_blank">Facebook</a>.
                            </td>
                        </tr>
                        @show
                    </table>
                </div>
            </div>
        </td>
        <td></td>
    </tr>
</table>
</body>
</html>
