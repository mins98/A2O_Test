<?php

namespace App\Utilities;
class Problem_one 
{
    public function queenPositions($request){
        $queenX = $request->rq-1;
        $queenY = $request->n-$request->cq;
        $obstaclesReal=$request->obstacles;
        
        $side=$request->n-1;
        $obstacles= array();
        if($request->k>0){
           
            foreach ($obstaclesReal as $val){
                $obstacles[]=[$val[0]-1,$side+1-$val[1]];
            }
        }
        $limits=$this->calculateLimits($queenX, $queenY,$side, $obstacles);

        $total=0;
        foreach ($limits as $lim){
            $total+=$lim[0];
        }

        return $data = array("queenX" => $queenX, "queenY" => $queenY,"side"=>$side,"limits"=>$limits,"obstacles"=>$obstacles, "total"=>$total);
    }

    function calculateLimits($queenX, $queenY,$side, $obstacles){

        $top=$this->top($queenX, $queenY,0);
        $bottom=$this->bottom($queenX, $queenY,$side,0);
        $left=$this->left($queenX, $queenY,0);
        $right=$this->right($queenX, $queenY,$side,0);

        $topLeft=$this->topLeft($queenX, $queenY,$side,0);
        $topRight=$this->topRight($queenX, $queenY,$side,0);
        $bottomRight=$this->bottomRight($queenX, $queenY,$side,0);
        $bottomLeft=$this->bottomLeft($queenX, $queenY,$side,0);
        $limits=array("top"=>$top,"bottom"=>$bottom,"left"=>$left,"right"=>$right, "topLeft"=>$topLeft,"topRight"=>$topRight,"bottomRight"=>$bottomRight,"bottomLeft"=>$bottomLeft);
        if(count($obstacles)>0){
            foreach ($obstacles as $val){
                $subtX= $queenX-$val[0];
                $subtY=$queenY-$val[1];
                if($this->isRealObstacle($subtX,$subtY)){
                    $limits= $this->recalculateLimits($queenX,$queenY,$val[0],$val[1],$limits);
                }

            }
        }
        
        return $limits;
    }

    function recalculateLimits($qx,$qy,$x,$y,$limits){
        $subtX= $qx-$x;
        $subtY=$qy-$y;
        //lateral
        if($subtX==0){
            //top
            if($subtY>0){
                if($subtY<=$qy-$limits["top"][1][1])
                    $limits["top"]=[$subtY-1,[$x,$y]];
            }
            //bottom
            else if($subtY<0){
                if($subtY>=$qy-$limits["bottom"][1][1])
                    $limits["bottom"]=[abs($subtY)-1,[$x,$y]];
            }
        }
        //horizontal
        if($subtY==0){
            //left
            if($subtX>0){
                if($subtX<=$qx-$limits["left"][1][0])
                    $limits["left"]=[$subtX-1,[$x,$y]];
            }
            //right
            else if($subtX<0){
                if($subtX>=$qx-$limits["right"][1][0])
                    $limits["right"]=[abs($subtX)-1,[$x,$y]];
            }
        }

        else{
            //topLeft
            if($subtX >0 && $subtY>0){
                if(abs($subtX)<=abs($qx-$limits["topLeft"][1][0]))
                    $limits["topLeft"]=[abs($subtX)-1,[$x,$y]];
            }
            //bottomRight
            else if($subtX <0 && $subtY<0){
                if(abs($subtX)<=abs($qx-$limits["bottomRight"][1][0]))
                $limits["bottomRight"]=[abs($subtX)-1,[$x,$y]];
            }
            //topRight
            else if($subtX <0 && $subtY>0){
                if(abs($subtX)<=abs($qx-$limits["topRight"][1][0]))
                $limits["topRight"]=[abs($subtX)-1,[$x,$y]];
            }
            //bottomLeft
            else if($subtX >0 && $subtY<0){
                if(abs($subtX)<=abs($qx-$limits["bottomLeft"][1][0]))
                $limits["bottomLeft"]=[abs($subtX)-1,[$x,$y]];
            }
        }


        //diagonal

        return $limits;
    }
    function isRealObstacle($subtX,$subtY){
        if($subtX==0 || $subtY==0)
            return true;
        if(abs($subtX) == abs($subtY))
            return true;

        return false;

    }
    function top($queenX,$queenY,$cont){
        $queenY--;
        if($queenY==0 ){
            return [$cont+1,[$queenX,$queenY]];
        }
        else if($queenY>=0)
            return $this->top($queenX,$queenY,$cont+1);
        else 
            return [$cont,[$queenX,$queenY+1]];

    }
    function bottom($queenX,$queenY,$side,$cont){
        $queenY++;
        if($queenY==$side ){
            return [$cont+1,[$queenX,$queenY]];
        }
        else if($queenY<=$side)
            return $this->bottom($queenX,$queenY,$side,$cont+1);
        else 
            return [$cont,[$queenX,$queenY-1]];

    }
    function left($queenX,$queenY,$cont){
        $queenX--;
        if($queenX==0 ){
            return [$cont+1,[$queenX,$queenY]];
        }
        else if($queenX>=0)
            return $this->left($queenX,$queenY,$cont+1);
        else 
            return [$cont,[$queenX+1,$queenY]];
    }
    function right($queenX,$queenY,$side,$cont){
        $queenX++;
        if($queenX==$side ){
            return [$cont+1,[$queenX,$queenY]];
        }
        else if($queenX<=$side)
            return $this->right($queenX,$queenY,$side,$cont+1);
        else 
            return [$cont,[$queenX-1,$queenY]];

    }

    function isLimit($queenX,$queenY,$side){
        if(($queenX>0 && $queenX<$side)&&($queenY>0 && $queenY<$side))
            return false;
        else
            return true;
    }
    function inRange($queenX,$queenY,$side){
        if(($queenX>=0 && $queenX<=$side)&&($queenY>=0 && $queenY<=$side))
            return true;
        else
            return false;
    }
    function topLeft($queenX,$queenY,$side,$cont){
        $queenX--;
        $queenY--;
        if($this->inRange($queenX,$queenY,$side)){
            if($this->isLimit($queenX,$queenY,$side)){
                return [$cont+1,[$queenX,$queenY]];
            }
            else 
                return $this->topLeft($queenX,$queenY,$side,$cont+1);
        }
        else
            return [$cont,[$queenX+1,$queenY+1]];
    }
    function topRight($queenX,$queenY,$side,$cont){
        $queenX++;
        $queenY--;
        if($this->inRange($queenX,$queenY,$side)){
            if($this->isLimit($queenX,$queenY,$side)){
                return [$cont+1,[$queenX,$queenY]];
            }
            else 
                return $this->topRight($queenX,$queenY,$side,$cont+1);
        }
        else
            return [$cont,[$queenX-1,$queenY+1]];

    }

    function bottomLeft($queenX,$queenY,$side,$cont){
        $queenX--;
        $queenY++;
        if($this->inRange($queenX,$queenY,$side)){
            if($this->isLimit($queenX,$queenY,$side)){
                return [$cont+1,[$queenX,$queenY]];
            }
            else 
                return $this->bottomLeft($queenX,$queenY,$side,$cont+1);
        }
        else
            return [$cont,[$queenX+1,$queenY-1]];
    }
    function bottomRight($queenX,$queenY,$side,$cont){
        $queenX++;
        $queenY++;
        if($this->inRange($queenX,$queenY,$side)){
            if($this->isLimit($queenX,$queenY,$side)){
                return [$cont+1,[$queenX,$queenY]];
            }
            else 
                return $this->bottomRight($queenX,$queenY,$side,$cont+1);
        }
        else
            return [$cont,[$queenX-1,$queenY-1]];
    }
}
