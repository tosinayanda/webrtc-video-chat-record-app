<?php
function getFilesFromDirectory($dir)
{
    $files = scandir($dir);

    //Trim out Unwanted Files
    $filestomerge=array();
    foreach($files as $file)
    {
        
        $filestoskip=array(".","..");
        if(!in_array($file,$filestoskip) && isset(explode('-',$file)[1]))
        {
            //var_dump($file);
            $filestomerge[]=$file;
        }
    
    }
    return $filestomerge;
}
function selectVideoandAudioPairs($files)
{
    $pairsToBeMerged=array();
    $keyIdfiles=array();
    //get conversation recording key without extension
    foreach($files as $file)
    {
        $keyId=array();
        $keyId["name"]=$file;
        $keyId["key"]=explode('-',$file)[0];
        $keyIdfiles[]=$keyId;
       // echo $file."<br/>";
    }
    foreach($keyIdfiles as $file1)
    {
       // echo  $file1["name"]."<br/>";
        //$pairsToBeMerged[$file1["key"]]=$file1["key"];
        if(isset($pairsToBeMerged[$file1["key"]]))
        {
             //echo $pairsToBeMerged[$file1["key"]];
            //exit()
            continue;
        }
        foreach($keyIdfiles as $file2)
        {
            if($file1["name"]==$file2["name"])
            {
                continue;
            }
            if($file1["key"]!==$file2["key"])
            {    
                continue;
            }
          //  echo  $file2["name"]."<br/>";
            $pairsToBeMerged[$file1["key"]]=array("key"=>$file1["key"],"file1"=>$file1["name"],"file2"=>$file2["name"]);
           // echo $file."<br/>";
        }
    }
   // var_dump($keyIdfiles);

    return $pairsToBeMerged;
}
function mergeVideo($dir,$pairs)
{

}
function mergeAudio($dir,$pairs)
{

}
function mergeAudioAndVideo($dir,$pairs)
{
    //Merge Videos Together
    echo "Starting Video Merge ffmpeg...\n\n";
    chdir($dir);
    foreach($pairs as $key=>$value)
    {
        //echo "C:/ffmpeg/bin/ffmpeg.exe -i ".$value["file1"]." -i ".$value["file2"]." -filter_complex hstack ".$key.".mp4 2> ffmpeg.log &";
        echo shell_exec("C:/ffmpeg/bin/ffmpeg.exe -i ".$value["file1"]." -i ".$value["file2"]." -filter_complex hstack ".$key.".mp4 2> ffmpeg.log &");
        echo "<br/>";
        //remove files from directory
        if(file_exists($key.".mp4"))
        {
            unlink($value["file1"]);
            unlink($value["file2"]);
        }    
    }
    //echo shell_exec("C:/ffmpeg/bin/ffmpeg.exe -i 1.webm -i 2.webm -filter_complex hstack output1.mp4 2> ffmpeg.log &");
    // echo shell_exec("C:/ffmpeg/bin/ffmpeg.exe -i 1.webm -i 2.webm -filter_complex hstack output1.mp4 2>&1");
    //echo shell_exec("ffmpeg -i 1.webm -i 2.webm -filter_complex hstack output2.mp4 >/dev/null 2> ffmpeg.log &");
    //ffmpeg -i 1.webm -i 2.webm -filter_complex hstack output.mp4 >/dev/null 2> ffmpeg.log &
    echo "Done.\n";
    //Merge Audio Together
    echo "Starting Video And Audio Merge ffmpeg...\n\n";
    echo shell_exec("ffmpeg -i video.mp4 -i audio.m4a -c:v copy -c:a copy output.mp4");
}
function startService()
{
    
    //List All Files in Upload Directory For Files with matching names

    $dir = "../uploads";

    $filestomerge=getFilesFromDirectory($dir);
    $pairs= selectVideoandAudioPairs($filestomerge);
    mergeAudioAndVideo($dir,$pairs);
    var_dump($pairs);
}

    
    startService();
?>

