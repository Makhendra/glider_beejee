<?php


namespace App\Tasks\Graphs;


class GraphImageService
{
    public function getImage($graph)
    {
        $c = count($graph);
        $image = imagecreatefrompng(public_path("graphs/$c.png"));
//        $line_color = imagecolorallocate($image, 0, 0, 0); //black
//        $line_color = imagecolorallocate($image, 228, 210, 99); //yellow
        $line_color = imagecolorallocate($image, 119, 172, 184); //blue
        imagesetthickness($image, 3);
        $coordinates = self::coordinateMatrix($c);
        foreach ($graph as $key => $vertexRow) {
            $lines[$key] = [];
            foreach ($vertexRow as $n => $d) {
                if ($d != 0 and !in_array($n, $lines[$key])) {
                    $lines[$key][] = $n;
                    imageline(
                        $image,
                        $coordinates[$key]['x'],
                        $coordinates[$key]['y'],
                        $coordinates[$n]['x'],
                        $coordinates[$n]['y'],
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
                    ['x' => 120, 'y' => 120],
                    ['x' => 595, 'y' => 65],
                    ['x' => 80, 'y' => 640],
                    ['x' => 525, 'y' => 750],
                    ['x' => 875, 'y' => 455],
                ];
                break;
            case 6:
                $coordinates = [
                    ['x' => 95, 'y' => 145],
                    ['x' => 555, 'y' => 70],
                    ['x' => 885, 'y' => 280],
                    ['x' => 800, 'y' => 698],
                    ['x' => 380, 'y' => 880],
                    ['x' => 120, 'y' => 595],
                ];
                break;
            case 7:
                $coordinates = [
                    ['x' => 107, 'y' => 133],
                    ['x' => 543, 'y' => 68],
                    ['x' => 920, 'y' => 232],
                    ['x' => 865, 'y' => 633],
                    ['x' => 645, 'y' => 905],
                    ['x' => 230, 'y' => 870],
                    ['x' => 93, 'y' => 540],
                ];
                break;
            default:
                $coordinates = [];
                break;
        }
        shuffle($coordinates);
        return $coordinates;
    }
}

