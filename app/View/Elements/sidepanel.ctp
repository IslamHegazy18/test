<div id="sidepanel">

    <div id="contacts">
        <ul>
            <?php foreach ($messages as $msg) { ?>
                <li class="contact">
                    <a class="btn" href="<?php echo $this->Html->url(array("controller" => "Aiwacsmessages", "action" => "view", $msg['aiwa_cs_messages']['id'])); ?>">
                        <div class="wrap">
                            <img src="http://emilcarlsson.se/assets/louislitt.png" alt="" />
                            <div class="meta">
                                <p class="name"><?= $msg['users']['fname'] . ' ' . $msg['users']['lname'] ?></p>
                                <p class="preview"><?= $msg['aiwa_cs_messages']['message'] ?></p>
                                <p class="cre"><?= $msg['aiwa_cs_messages']['created'] ?></p>
                            </div>
                        </div>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>

</div>