<?php if (!defined('APPLICATION')) exit(); ?>

<?php

  if (!count($this->data('SearchResults')) && $this->data('SearchTerm')) {
    echo '<p class="NoResults">', sprintf(t('No results for %s.', 'No results for <b>%s</b>.'), $this->data('SearchTerm')), '</p>';
  }
  else {
    echo '<h4 class="discussions-label">Discussions</h4>';
  }

?>
    <ol id="search-results" class="DataList DataList-Search Discussions" start="<?php echo $this->data('From'); ?>">
        <?php foreach ($this->data('SearchResults') as $Row): ?>
            <li class="Item Item-Search">

                <div class="Item-Body Media Discussion">
                    <div class="discussion-author">
                      <?php
                      $Photo = userPhoto($Row, array('LinkClass' => 'Img'));
                      if ($Photo) {
                          echo $Photo;
                      }
                      ?>
                    </div>
                    <div class="Media-Body">
                      <div class="Title"><?php echo anchor(htmlspecialchars($Row['Title']), $Row['Url']); ?></div>

                        <div class="Meta">
                            <?php
                            echo ' <span class="MItem MItem-Author">'.
                                sprintf(t('by %s'), userAnchor($Row)).
                                '</span>';

                            echo Bullet(' ');
                            echo ' <span clsss="MItem MItem-DateInserted">'.
                                Gdn_Format::date($Row['DateInserted'], 'html').
                                '</span> ';


                            if (isset($Row['Breadcrumbs'])) {
                                echo Bullet(' ');
                                echo ' <span class="MItem MItem-Location">'.Gdn_Theme::Breadcrumbs($Row['Breadcrumbs'], false).'</span> ';
                            }

                            if (isset($Row['Notes'])) {
                                echo ' <span class="Aside Debug">debug('.$Row['Notes'].')</span>';
                            }
                            ?>
                        </div>
                        <?php
                        $Count = val('Count', $Row);
                        //            $i = 0;
                        //            if (isset($Row['Children'])) {
                        //               echo '<ul>';
                        //
                        //               foreach($Row['Children'] as $child) {
                        //                  if ($child['PrimaryID'] == $Row['PrimaryID'])
                        //                     continue;
                        //
                        //                  $i++;
                        //                  $Count--;
                        //
                        //                  echo "\n<li>".
                        //                     anchor($child['Summary'], $child['Url']);
                        //                     '</li>';
                        //
                        //                  if ($i >= 3)
                        //                     break;
                        //               }
                        //               echo '</ul>';
                        //            }

                        if (($Count) > 1) {
                            $url = $this->data('SearchUrl').'&discussionid='.urlencode($Row['DiscussionID']).'#search-results';
                            echo '<div>'.anchor(Plural($Count, '%s result', '%s results'), $url).'</div>';
                        }
                        ?>
                    </div>
                    <div class="Summary">
                        <?php echo $Row['Summary']; ?>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ol>

<?php
echo '<div class="PageControls Bottom">';

$RecordCount = $this->data('RecordCount');
if ($RecordCount)
    echo '<span class="Gloss">'.plural($RecordCount, '%s result', '%s results').'</span>';

PagerModule::write(array('Wrapper' => '<div %1$s>%2$s</div>'));

echo '</div>';
