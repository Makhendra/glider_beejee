<?php


namespace App\Tasks\Graphs;


class GraphImageService
{
    public function getImage($graph, $alpha)
    {
        $width = 500;
        $height = 500;
        $image = imagecreate($width, $height);
        // Задний фон
        imagecolorallocate($image, 255, 255, 255);
        // Цвет текста
        $text_color = imagecolorallocate($image, 0, 0, 0);
        $font = public_path('font.ttf');
        $coordinates = self::coordinateMatrix($graph);
        dd($coordinates);
        foreach ($coordinates as $key => $point) {
            imagettftext(
                $image,
                10,
                0,
                round($point['x'], 0),
                round($point['y'], 0),
                $text_color,
                $font,
                $alpha[$key]
            );
        }
//        $coordinate = [];
//        foreach ($graph as $key => $vertexRow) {
//            $coordinate[$key] = [
//                'y' => random_int(50, $height - 50),
//                'x' => random_int(50, $width - 50)
//            ];
//            imagettftext(
//                $image,
//                10,
//                0,
//                $coordinate[$key]['x'],
//                $coordinate[$key]['y'],
//                $text_color,
//                $font,
//                $alpha[$key]
//            );
//        }
        $lines = [];
        foreach ($graph as $key => $vertexRow) {
            $lines[$key] = [];
            foreach ($vertexRow as $n => $d) {
                if ($n != 0 and $n != '-' and !in_array($n, $lines[$key])) {
                    $lines[$key][] = $n;
                    imageline(
                        $image,
                        $coordinates[$key]['x'] + 10,
                        $coordinates[$key]['y'] + 2,
                        $coordinates[$n]['x'] + 10,
                        $coordinates[$n]['y'] + 2,
                        $text_color
                    );
                }
            }
        }
        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        return base64_encode($imageData);
    }

    public function coordinateMatrix($graph, $maxDistance = 250)
    {
        $t = 0;
        $k = 100;
        $edgeGravityKof = 10 / ($maxDistance);
        $gravityDistanceSqr = 10 * ($maxDistance * $maxDistance);
        $l = count($graph);
        $coordinates = [];
        for ($i = 0; $i < $l; $i++) {
            $coordinates[] = ['x' => 1, 'y' => 1];
        }
        $bChanged = false;
        while ($t < $k && $bChanged) {
            foreach ($graph as $vertex1 => $edj1) {
                foreach ($graph as $vertex2 => $edj2) {
                    if ($vertex1 == $vertex2) {
                        continue;
                    }
                    $rsq = pow($coordinates[$vertex2]['x'] - $coordinates[$vertex1]['x'], 2) +
                        pow($coordinates[$vertex2]['y'] - $coordinates[$vertex1]['y'], 2);
                    if ($rsq == 0) {
                        $rsq = 1;
                    }
                    $f = $gravityDistanceSqr / $rsq;
                    $coordinates[$vertex2]['x'] = $coordinates[$vertex2]['x'] / $l * $f;
                    $coordinates[$vertex2]['y'] = $coordinates[$vertex2]['y'] / $l * $f;
                }
                foreach ($graph as $vertex2 => $edj) {
                    $x = $coordinates[$vertex2]['x'] - $coordinates[$vertex1]['x'];
                    $y = $coordinates[$vertex2]['y'] - $coordinates[$vertex1]['y'];
                    $distance = sqrt($x * $x + $y * $y);

                    if ($distance > $maxDistance) {
                        $f = $edgeGravityKof * ($distance - $maxDistance);
                        $coordinates[$vertex2]['x'] = $x / $l * $f;
                        $coordinates[$vertex2]['y'] = $y / $l * $f;
                    }
                }
                $x = $coordinates[$vertex1]['x'] - $coordinates[$vertex1]['x'];
                $y = $coordinates[$vertex1]['y'] - $coordinates[$vertex1]['y'];
                $distanceToCenter = sqrt($x*$x + $y*$y);
                $f = centerPoint . subtract(currentVertex . object . position) . normalize(
                        distanceToCenter * kCenterForce
                    );
//            currentVertex.net_force = currentVertex.net_force.add(force);
//
//            // counting the velocity (with damping 0.85)
//            currentVertex.velocity = currentVertex.velocity.add(currentVertex.net_force);
            }
            $t += 1;

            $bChanged = false;

//            for(i = 0; i < vertexData.length; i++) // set new positions
//     {
//         var v = vertexData[i];
//         var velocity = v.velocity;
//         if (velocity.length() > velocityMax)
//         {
//             velocity = velocity.normalize(velocityMax);
//         }
//         v.object.position = v.object.position.add(velocity);
//         if (velocity.length() >= 1)
//         {
//             bChanged = true;
//         }
//     }
//            k++;
        }
        return $coordinates;
    }
}

