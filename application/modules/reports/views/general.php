<style>
    .draft{color:#999}
    .sent{color:#3A87AD}
    .viewed{color:#F89406}
    .paid,.approved{color:#468847}
    .rejected,.overdue{color:#B94A48}
    .canceled{color:#333}
</style>
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <i class="icon-globe theme-font hide"></i>
                    <span class="caption-subject theme-font bold uppercase">Meilleurs Clients </span>
                </div>
            </div>
            <div class="portlet-body">

                <div class="row">   
                    <?php foreach ($devises as $devise) { ?>
                    <div class="col-xs-12 col-md-6">


                        <div class="panel panel-default overview">

                            <div class="panel-heading">
                                <b><i class="fa fa-bar-chart fa-margin"></i> Meilleurs Clients (<?php echo $devise->devise_symbole; ?>)</b>
                                <span class="pull-right text-muted"> </span>

                            </div>



                            <table   class="table table-striped table-bordered table-hover no-footer" >
                                <thead>
                                    <tr style="font-weight: bold;">
                                        <td>Nom & Prénom</td>
                                        <td>Société</td>
                                        <td>Montant</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 1; $i < 10; $i++) { ?>
                                    <tr>
                                        <td>Foulen Fouleni</td>
                                        <td>Company Name</td>
                                        <td><?php echo format_devise(rand(10000, 30000), $devise->devise_id); ?></td>

                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>    
                    <?php } ?>

                </div>


            </div>
        </div>





    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <i class="icon-globe theme-font hide"></i>
                    <span class="caption-subject theme-font bold uppercase">Meilleurs Produits </span>
                </div>
            </div>
            <div class="portlet-body">

                <div class="row">   

                    <div class="col-xs-12 col-md-12">


                        <div class="panel panel-default overview">

                            <div class="panel-heading">
                                <b><i class="fa fa-bar-chart fa-margin"></i> Meilleurs Produits</b>
                                <span class="pull-right text-muted"> </span>

                            </div>



                            <table   class="table table-striped table-bordered table-hover no-footer" >
                                <thead>
                                    <tr style="font-weight: bold;">
                                        <td>Code</td>
                                        <td>Famille</td>
                                        <td>Nombre</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 1; $i < 10; $i++) { ?>
                                    <tr>
                                        <td>SWD</td>
                                        <td>Family</td>
                                        <td>5</td>

                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>    


                </div>


            </div>
        </div>





    </div>
</div>


