<?php if (!defined('APPLICATION')) exit();
$Session = Gdn::session();

// Check that we have the necessary tools to allow image uploading
$AllowImages = Gdn_UploadImage::CanUploadImages();

// Is the photo hosted remotely?
$RemotePhoto = IsUrl($this->User->Photo, 0, 7);

// Define the current profile picture
$Picture = '';
if ($this->User->Photo != '') {
    if (IsUrl($this->User->Photo))
        $Picture = img($this->User->Photo, array('class' => 'ProfilePhotoLarge'));
    else
        $Picture = img(Gdn_Upload::url(changeBasename($this->User->Photo, 'p%s')), array('class' => 'ProfilePhotoLarge'));
}

// Define the current thumbnail icon
$Thumbnail = $this->User->Photo;
if ($Thumbnail && !isUrl($Thumbnail)) {
    $Thumbnail = Gdn_Upload::url(changeBasename($Thumbnail, 'n%s'));
} else {
    $Thumbnail = UserModel::getDefaultAvatarUrl($this->User);
}

$Thumbnail = img($Thumbnail, array('alt' => t('Thumbnail')));
?>
<h4 class="H discussions-label"><?php echo $this->data('Title'); ?></h4>
<div class="SmallPopup FormTitleWrapper">
    <?php
    echo $this->Form->open(array('enctype' => 'multipart/form-data'));
    echo $this->Form->errors();
    ?>
    <ul>
        <?php if ($Picture != '') { ?>
            <li class="CurrentPicture">
                <table>
                    <thead>
                    <tr>
                        <td><?php echo t('Picture'); ?></td>
                        <td><?php echo t('Thumbnail'); ?></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?php
                            echo $Picture;
                            if ($this->User->Photo != '' && $AllowImages && !$RemotePhoto) {
                            echo wrap(Anchor(t('Remove Picture'), userUrl($this->User, '', 'removepicture').'?tk='.$Session->TransientKey(), 'Button Danger PopConfirm'), 'p');
                            ?>
                        </td>
                        <td><?php
                            echo $Thumbnail;
                            echo wrap(Anchor(t('Edit Thumbnail'), userUrl($this->User, '', 'thumbnail'), 'Button'), 'p');
                            }
                            ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </li>
        <?php } ?>
        <li>
            <p><?php echo t('Select an image on your computer (2mb max)'); ?></p>
            <?php echo $this->Form->Input('Picture', 'file'); ?>
        </li>
    </ul>
    <div
        class="DismissMessage WarningMessage"><?php echo t('By uploading a file you certify that you have the right to distribute this picture and that it does not violate the Terms of Service.'); ?></div>
    <?php echo $this->Form->close('Upload', '', array('class' => 'Button Primary')); ?>
</div>
