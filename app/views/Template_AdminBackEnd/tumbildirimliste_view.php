<aside class="right-side">
    <section class="content-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 top-left">
                <h3>
                    <i class="fa fa-th"></i> <?php echo $data["TumBildirimler"]; ?>
                    <small id="smallBildirim"><?php if (count($model[0]['AdminBildirimCount']) > 0) { ?>
                            <?php
                            echo $model[0]['AdminBildirimCount'];
                        } else {
                            ?>
                            <?php
                            echo '0 ';
                        }
                        ?></small><small> <?php echo $data["Toplam"]; ?></small>
                </h3>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-responsive table-bordered table-hover table-condensed" id="adminBildirimTable">
                    <thead>
                        <tr>
                            <th class="hidden-xs"><?php echo $data["Bildirim"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Gonderen"]; ?></th>
                            <th class="hidden-xs"><?php echo $data["Tarih"]; ?></th>
                        </tr>
                    </thead>

                    <tbody id="adminBildirimRow">
                        <?php foreach ($model as $bildirimModel) { ?>
                            <tr>
                                <td>
                                    <a data-toggle="tooltip" data-placement="top" href="http://localhost/SProject/adminweb/<?php echo $bildirimModel["BildirimUrl"]; ?>" title="<?php echo $data["Detay"]; ?>" value="<?php echo $bildirimModel["BildirimID"]; ?>">
                                        <i class="<?php echo $bildirimModel["BildirimIcon"]; ?> <?php echo $bildirimModel["BildirimRenk"]; ?>" ></i> <?php echo $bildirimModel["BildirimText"]; ?>
                                    </a>
                                </td>
                                <td class="hidden-xs"><?php echo $bildirimModel['BildirimGonderenAd']; ?></td>
                                <td class="hidden-xs"><?php echo $bildirimModel['BildirimTarih']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</aside>
<script>
    $('#adminBildirimTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });
</script>



