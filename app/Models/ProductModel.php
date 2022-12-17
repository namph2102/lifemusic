<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class ProductModel extends Model
{
    use HasFactory;
    protected function handTime($time)
    {
        $date1 = date("Y-m-d H:i:s");
        $date2 = $time;
        $diff = abs(strtotime($date2) - strtotime($date1));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
        $minutes = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
        $seconds = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minutes * 60));

        if (!empty($years)) return " $years năm trước";
        if (!empty($months)) return " $months tháng trước";
        if (!empty($days)) return "$days ngày trước";
        if (!empty($hours)) return "$hours giờ trước";
        if (!empty($minutes)) return "$minutes phút trước";
        if (!empty($seconds)) return "$seconds  giây trước";
        if (!$diff) return "Vừa xong";
    }
    
    public function getValues($nameTable,$action='all',$arrange,$kindArr='desc'){
        if($action!='all'){

            if($kindArr=='asc'){
                return DB::table($nameTable)->orderBy($arrange)->limit($action)->get();   
            }
            return DB::table($nameTable)->orderByDesc($arrange)->limit($action)->get();
        }else{
            if($kindArr=='asc'){
                return DB::table($nameTable)->orderBy($arrange)->get();
            }
            return DB::table($nameTable)->orderByDesc($arrange)->get();     
        }            
    }
    public function getArtist($id='all'){
        
        $dbsingers= [];
        if($id!='all'){
            $dbsingers= DB::table('singer')->where('id_singer',$id)->first();
            $dbsingers->totalLove=DB::table('song')->where('id_singer',$dbsingers->id_singer)->sum('loves');
            $dbsingers->totalListen=DB::table('song')->where('id_singer',$dbsingers->id_singer)->sum('listen');
        }else{
            $dbsingers= DB::table('singer')->get();
            foreach($dbsingers as $singer){
                $singer->totalLove=DB::table('song')->where('id_singer',$singer->id_singer)->sum('loves');
                $singer->totalListen=DB::table('song')->where('id_singer',$singer->id_singer)->sum('listen');
               
            };
            for($i=0;$i<count($dbsingers)-1;$i++){
                for($j=$i+1;$j<count($dbsingers);$j++){
                    if($dbsingers[$i]->totalListen<$dbsingers[$j]->totalListen){
                        $tam= $dbsingers[$i];
                        $dbsingers[$i]=$dbsingers[$j];
                        $dbsingers[$j]=$tam;
                    }
                }
            }
        }
      
        return $dbsingers;
    }
    
}

