<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 11-Oct-14
 * Time: 13:13
 */

if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}
get_header(); ?>

<?php // Get Theme Options from Database
//$theme_options = dynamicnews_theme_options();
$act = JIH_CONTROLLER_ACTION_PARAM;
$model = JihViewHelper::getInstance()->viewData;
/** @var Date $date */
$date = $model['startDate'];
?>

<div id="wrap" class="container clearfix template-frontpage">
    <section id="content" class="primary" role="main">

        <div id="post-2" class="post-2 page type-page status-publish hentry">

            <h2 class="page-title">Prayer Calendar</h2>
            <div style="float:right;">
                <select name="calendar" id="jih-calendar">
                    <option value="12">TestCalendar</option>
                </select>
                <a href="/?<?= $act ?>=WeekView" class="btn btn-primary">Today</a>
                <a href="/?<?= $act ?>=WeekView&date=<?= $date->CloneAddDays(-7) ?>" class="btn btn-primary">&lt;</a>
                <a href="/?<?= $act ?>=WeekView&date=<?= $date->CloneAddDays(7) ?>" class="btn btn-primary">&gt;</a>
            </div>


            <table id="jih-calendar-week" class="table table-striped table-bordered calendar fixed">
                <thead>
                <tr>
                    <th></th>
                    <th><?= $hDate = clone $date ?></th>
                    <th><?= $hDate->addDay() ?></th>
                    <th><?= $hDate->addDay() ?></th>
                    <th><?= $hDate->addDay() ?></th>
                    <th><?= $hDate->addDay() ?></th>
                    <th><?= $hDate->addDay() ?></th>
                    <th><?= $hDate->addDay() ?></th>
                </tr>
                </thead>
                <tbody>
                <?php for($i =0; $i<24; $i++ ) { ?>
                <tr>
                    <th><?= $i ?>:00 - <?= $i+1 ?>:00</th>
                    <td data-date="<?= $pdate = clone $date ?>" data-time="<?= $i ?>:00"><?= JihDb::getNameByHour(1,$pdate,$i) ?></td>
                    <td data-date="<?= $pdate->addDay() ?>" data-time="<?= $i ?>:00"><?= JihDb::getNameByHour(1,$pdate,$i) ?></td>
                    <td data-date="<?= $pdate->addDay() ?>" data-time="<?= $i ?>:00"><?= JihDb::getNameByHour(1,$pdate,$i) ?></td>
                    <td data-date="<?= $pdate->addDay() ?>" data-time="<?= $i ?>:00"><?= JihDb::getNameByHour(1,$pdate,$i) ?></td>
                    <td data-date="<?= $pdate->addDay() ?>" data-time="<?= $i ?>:00"><?= JihDb::getNameByHour(1,$pdate,$i) ?></td>
                    <td data-date="<?= $pdate->addDay() ?>" data-time="<?= $i ?>:00"><?= JihDb::getNameByHour(1,$pdate,$i) ?></td>
                    <td data-date="<?= $pdate->addDay() ?>" data-time="<?= $i ?>:00"><?= JihDb::getNameByHour(1,$pdate,$i) ?></td>
                </tr>
                </tbody>
                <?php } ?>
            </table>
            <div class="entry clearfix">
                <p>This is an example page. It’s different from a blog post because it will stay in one place and will show up in your site navigation (in most themes). Most people start with an About page that introduces them to potential site visitors. It might say something like this:</p>

            </div>

        </div>
    </section>

    <?php get_sidebar(); ?>

</div>
<div id="jih-plan-hour" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Schedule Prayer Hour</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" action="/?<?= $act ?>=SavePrayerHour" method="post">
                    <div class="hide">
                        <input id="jih-calendar-id" type="text" class="form-control" name="scheduleId" placeholder="Date" value="1">
                        <input id="redirect-url" type="text" class="form-control" name="redirectUrl" value="">
                    </div>
                    <div class="form-group">
                        <label for="jih-date" class="col-sm-2 control-label">Datetime</label>
                        <div class="col-sm-10">
                            <input id="jih-date" type="datetime" class="form-control" name="datetime" placeholder="Date">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jih-name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input id="jih-name" type="text" class="form-control" name="name" placeholder="Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jih-email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="jih-email" name="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jih-email" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10">
                            <textarea id="jih-description" class="form-control" rows="3" name="description" placeholder="Description"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jih-pin" class="col-sm-2 control-label">Pincode</label>
                        <div class="col-sm-10">
                            <input type="text" name="pin" class="form-control" id="jih-pin" placeholder="Pin">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php get_footer(); ?>
