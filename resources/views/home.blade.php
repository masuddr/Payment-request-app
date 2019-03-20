@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <?php
                    session_start();
                    if (isset($_SESSION['emptycheck']) && !empty($_SESSION['emptycheck'])){

                    if ($num > 0) {
                    ?>
                <table border="1" cellpadding="3">
                    <tr><td colspan="2" align="center">Your Info</td></tr>
                    <tr>
                        <td>Name: <?php echo $arr['name']; ?></td>
                    </tr>

                    <tr>
                        <td>Email: <?php echo $arr['email']; ?></td>
                    </tr>
                </table>
                <?php }else{ ?>
                User not found.
                <?php }
                    }else{
                        echo 'session is empty';
                } ?>
            </div>
        </div>
    </div>
</div>
@endsection
