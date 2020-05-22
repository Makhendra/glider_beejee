<?php


namespace App\Tasks\Graphs\Services;


class GraphImageService
{
    public function getImage($graph)
    {
        $c = count($graph);
        $image = imagecreatefrompng(public_path("graphs/$c.png"));
        $line_color = imagecolorallocate($image, 119, 172, 184); //blue
        imagesetthickness($image, 3);
        $coordinates = self::coordinateMatrix($c);
        foreach ($graph as $rowKey => $vertexRow) {
            $lines[$rowKey] = [];
            foreach ($vertexRow as $edjKey => $distance) {
                if ($distance != 0 and !in_array($edjKey, $lines[$rowKey])) {
                    $lines[$rowKey][] = $edjKey;
                    imageline(
                        $image,
                        $coordinates[$rowKey]['x'],
                        $coordinates[$rowKey]['y'],
                        $coordinates[$edjKey]['x'],
                        $coordinates[$edjKey]['y'],
                        $line_color
                    );
                }
            }
        }
        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        return base64_encode($imageData);
    }

    public function coordinateMatrix($c)
    {
        switch ($c) {
            case 5:
                $coordinates = [
                    'А' => ['x' => 110, 'y' => 120],
                    'Б' => ['x' => 595, 'y' => 60],
                    'В' => ['x' => 70, 'y' => 640],
                    'Г' => ['x' => 525, 'y' => 760],
                    'Д' => ['x' => 875, 'y' => 440],
                ];
                break;
            case 6:
                $coordinates = [
                    'А' => ['x' => 95, 'y' => 145],
                    'Б' => ['x' => 555, 'y' => 70],
                    'В' => ['x' => 890, 'y' => 280],
                    'Г' => ['x' => 800, 'y' => 698],
                    'Д' => ['x' => 380, 'y' => 880],
                    'Е' => ['x' => 120, 'y' => 595],
                ];
                break;
            case 7:
                $coordinates = [
                    'А' => ['x' => 100, 'y' => 133],
                    'Б' => ['x' => 543, 'y' => 68],
                    'В' => ['x' => 930, 'y' => 232],
                    'Г' => ['x' => 875, 'y' => 633],
                    'Д' => ['x' => 645, 'y' => 910],
                    'Е' => ['x' => 230, 'y' => 870],
                    'Ж' => ['x' => 87, 'y' => 540],
                ];
                break;
            default:
                $coordinates = [];
                break;
        }
//        shuffle($coordinates);
        return $coordinates;
    }
}

