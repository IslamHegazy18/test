<?php $paginator = $this->Paginator;
echo $this->Html->css(array('cake.generic'));
?>
<div class="page-title">
    <i class="icon-custom-form"></i>
    <h3>All <span class="semi-bold">Terms & Conditions</span></h3>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="grid simple ">
            <div class="grid-body no-border">
                <table class=" no-more-tables  table-condensed" id="example">
                    <tbody>
                        <?php echo $this->Form->create('Terms', array("url" => array("controller" => "Terms", "action" => "showall"))); ?>
                        <tr>
                            <td class=" col-lg-6"> <?php echo $this->Form->input('parent_id', array("label" => "Key", 'id' => "source", 'options' => array($keys_names), 'style' => 'width: 300px; margin-bottom:5px;')); ?> </td>
                            <td><?php echo $this->Form->submit('Search', array('class' => 'btn btn-primary btn-cons', 'title' => 'Approvals fillter', '$Approval_TypesID')); ?> </td>
							<td>
							<a class="btn-lg pull-right btn btn-primary btn-lg"  href="<?php echo $this->Html->url(array('controller' => 'Terms', 'action' => 'showall')); ?>" data-original-title="" title="" style="margin:5px; text-decoration: none;">English</a>
							</td>
							<td>
							<a class="btn-lg pull-right btn btn-primary btn-lg"  href="<?php echo $this->Html->url(array('controller' => 'Terms', 'action' => 'en_to_ar')); ?>" data-original-title="" title="" style="margin:5px; text-decoration: none;">عربى</a>
							</td>
                        </tr>
                    </tbody>
                </table>
                <table   class="table table-bordered no-more-tables  table-condensed" id="example">
                    <thead dir="rtl">
                        <tr style="background-color:darkgray;height:40px;">
                            <th style="text-align: center; font-size: large; "><b>ID</th>
                            <th style="text-align: center; font-size: large; "><b>Terms_EN</th>
                            <th style="text-align: center; font-size: large; "><b>Terms_AR</th>
                            <th style="text-align: center; font-size: large; "><b>Details</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        foreach ($keys_data as $key => $term) :
                            ?>
                            <tr>
                                <td><b><?php echo $term["TermsConditions"]["id"] ?></td>
                                <td><b><?php echo $term["TermsConditions"]["data_en"] ?></td>
                                <td><b><?php echo $term["TermsConditions"]["data_ar"] ?></td>
                                <td class = "text-center">
                                    <a class="btn" href="<?php echo $this->Html->url(array("controller" => "Terms", "action" => "edit", $term["TermsConditions"]["id"])); ?>">
                                        <i class="fa fa-info-circle"></i> Edit </a>
                                </td>
                            </tr>
                        <?php endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
