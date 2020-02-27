<?php echo "<?php\n"; ?>

use Illuminate\Support\Facades\Route;
//MAPPING_AREA_FOR_CRUD_DO_NOT_REMOVE_OR_EDIT_THIS_LINE_USE_AREA//

<?php echo "\n"; ?>
Route::name('<?php echo $vendor; ?>.')
    ->prefix('backend')
    ->middleware(['web', 'auth'])
    ->group(function () {

    //MAPPING_AREA_FOR_CRUD_DO_NOT_REMOVE_OR_EDIT_THIS_LINE//
});
