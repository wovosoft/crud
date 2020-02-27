<?php echo "<?php\n"; ?>

namespace <?php echo $vendor; ?>\<?php echo $package; ?>\Models;

use Illuminate\Database\Eloquent\Model;

class <?php echo $model; ?> extends Model
{
    <?php echo $table ?"":'//'; ?>protected $table = "<?php echo $table?$table:'table_name'; ?>";
    //protected $fillable = [];


}
