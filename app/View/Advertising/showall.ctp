<div class="page-title">
    <i class="icon-custom-form"></i>
    <h3>All <span class="semi-bold">Images</span></h3>
</div>

<div class="row" >
    <div class="col-md-12">
        <div class="grid simple ">
            <div class="grid-body no-border">
                <div >
                    <a class="btn-lg pull-right btn btn-primary btn-lg"  href="<?php echo $this->Html->url(array('controller' => 'Advertising', 'action' => 'add')); ?>" data-original-title="" title="" style="margin:5px;">ADD</a>
                </div>
                <table   class="table table-bordered no-more-tables">
                    <thead>
                        <tr >
                            <th hidden="hidden">Sort</th>
                            <th  style="text-align: center; font-size:130%">ID</th>
                            <th  style="text-align: center; font-size:130%">Image</th>
                            <th  style="text-align: center; font-size:130%">URL</th>
							<th  style="text-align: center; font-size:130%">Status</th>
                            <th  style="text-align: center; font-size:130%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($Images as $key => $image) { ?>
                            <tr>
                                <td style="font-size:130%;">
									<?php echo $image["AdvertisingImages"]["id"] ?>
								</td>
                                <td style="font-size:130%;">
									<img width="80" height="80" alt="" src="<?php echo Configure::read('img_url') . $image["AdvertisingImages"]["image_path"] ?>">
								</td>
                                <td style="font-size:130%;">
									<?php echo $image["AdvertisingImages"]["url"] ?>
								</td>
								<td style="font-size:130%;">
									<?php echo $image["AdvertisingImages"]["status"] ?>
								</td>
                                <td class = "text-center">
                                    <a class="btn" href="<?php echo $this->Html->url(array("controller" => "Advertising", "action" => "edit", $image["AdvertisingImages"]["id"])); ?>">
                                        <i class="fa fa-info-circle"></i> Edit </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

