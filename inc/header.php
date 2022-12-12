<?php
    error_reporting(E_ERROR | E_PARSE);//removes the undefined problem
    //session_start();

    include "config-files/connectiondb.php";

?>
<?php
    echo '<header class="header-section">
    <div class="header-top d-none d-lg-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <ul class="header-top-info">
                        <li>
                            <div class="left">
                                <i class="flaticon-phone-call"></i>
                            </div>
                            <div class="right">
                                <span class="d-block">Call Now</span>
                                <a href="Tel:9393993">+260 974 725 236</a>
                            </div>
                        </li>
                        <li>
                            <div class="left">
                                <i class="flaticon-clock"></i>
                            </div>
                            <div class="right">
                                <span class="d-block">Office Hours</span>
                                <a href="#0">8:00 am-5:00 pm</a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <ul class="d-flex justify-content-end account">
                        <li>
                            <a href="sign-in.php">Student</a>
                        </li>
                        <li>
                            <a href="backoffice-in.php">Backoffice</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>';
?>