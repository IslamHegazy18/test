<?php $paginator = $this->Paginator;
echo $this->Html->css(array('cake.generic'));

?>


<div id="frame">

    <div id="sidepanel">

        <div id="contacts">
            <ul>
                <?php foreach ($userMsg as $msg) { ?>
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


    <div class="content">
        <div class="contact-profile">
            <p>Harvey Specter</p>
        </div>
        <div class="messages">
            <ul>
                <?php foreach ($userMsg as $msgs) :  ?>

                    <?php if ($msgs['aiwa_cs_messages']['fromuserid_flag'] == 0) : ?>
                        <li class="sent">
                            <p><?= $msgs['aiwa_cs_messages']['message'] ?></p>
                        </li>
                    <?php else : ?>
                        <li class="replies">
                            <p><?= $msgs['aiwa_cs_messages']['message'] ?></p>
                        </li>
                    <?php endif; ?>

                <?php endforeach; ?>

            </ul>
        </div>
        <div class="message-input">
            <div class="wrap">

                <?php echo $this->Form->create('Post'); ?>
                <fieldset>

                    <?php
                    echo $this->Form->text('message');
                    ?>
                </fieldset>

                <?php echo $this->Form->end(__('Submit')); ?>


                <!-- <input type="text" placeholder="Write your message..." />
				<?= $this->Form->submit(
                    'Send',
                    array('class' => 'submit', 'title' => 'Custom Title', 'i' => 'fa fa-paper-plane')
                ); ?> -->

                <!-- <button class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button> -->



                <!-- <?php echo $this->Form->end(); ?> -->
            </div>
        </div>
    </div>
</div>