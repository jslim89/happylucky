<div class="grid_6">
    <div id="primary_image"><?php
        echo anchor(
            $monk->primary_image_url,
            img(array(
                'src'    => $monk->primary_image_url,
                'alt'    => $monk->monk_name,
                'width'  => '300',
                'height' => '300',
            )),
            array('rel' => 'lightbox')
        );
    ?></div>
    <hr />
    <div id="extra_image"><?php
        $image_list = array();
        $image_list_attr = array(
            'class' => 'grid-view'
        );
        foreach($monk->monk_image as $image) {
            $image_list[$image->id] = anchor(
                $image->url,
                img(array(
                    'src'    => $image->url,
                    'alt'    => $image->alt,
                    'width'  => '80',
                    'height' => '80',
                    'title' => $image->image_desc,
                )),
                array('rel' => 'lightbox')
            );
        }
        echo ul($image_list, $image_list_attr);
    ?></div>
</div>

<div class="grid_9">
    <div class="box">
        <div class="box-heading"><?php
            echo lang('monk_story');
        ?></div>
        <div class="box-content"><?php
            echo $monk->monk_story;
        ?></div>
    </div>
</div>
