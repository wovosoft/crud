<?php echo "<?php\n"; ?>


namespace <?php echo $vendor; ?>\<?php echo $package; ?>\Http\Controllers;

use App\Http\Controllers\Controller;

use Bornodhoni\CMSBase\Traits\BaseControllerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use <?php echo $model; ?> as ItemModel;

class <?php echo $controller; ?> extends Controller
{
    use BaseControllerTrait;
    public $itemModel;
    /**
     * @var array List of Relations to be loaded with the list() method
     */
    public $listWith = [

    ];
    /**
     * @var array List of Columns to be selected with the list() method
     */
    public $listSelectedColumns = [
        "*"
    ];

    public function __construct()
    {
        $this->itemModel = ItemModel::class;
    }

    public static function routes()
    {
        Route::post("<?php echo $package; ?>/list", '\\' . __CLASS__ . '@list')->name('<?php echo $package; ?>.List');
        Route::post("<?php echo $package; ?>/search", '\\' . __CLASS__ . '@search')->name('<?php echo $package; ?>.Search');
        Route::post("<?php echo $package; ?>/store", '\\' . __CLASS__ . '@store')->name('<?php echo $package; ?>.Store');
        Route::post("<?php echo $package; ?>/delete", '\\' . __CLASS__ . '@delete')->name('<?php echo $package; ?>.Delete');
    }

    public function store(Request $request)
    {
        try {
            $item = ItemModel::findOrNew($request->post('id'));
            if ($request->post('id')) {
                $item->updated_at = Carbon::now();
            }
            $item->saveOrFail();
            return response()->json([
                "status" => true,
                "title" => 'SUCCESS!',
                "type" => "success",
                "msg" =>  ($request->post('id') ? 'Edited' : 'Added') . ' Successfully'
            ]);
        } catch (\Exception $exception) {
            if(env('APP_DEBUG')){
                return response()->json([
                    "code" => $exception->getCode(),
                    "status" => false,
                    "title" => 'Failed!',
                    "type" => "warning",
                    "msg" => $exception->getMessage(),
                    "line" => $exception->getLine(),
                    "file" => $exception->getFile(),
                    "trace" => $exception->getTrace(),
                ], Response::HTTP_FORBIDDEN, [], JSON_PRETTY_PRINT);
            }
            return response()->json([
                "status" => false,
                "title" => 'Failed!',
                "type" => "warning",
                "msg" => "Unable to Process the request"
            ], Response::HTTP_FORBIDDEN);
        }
    }
}
