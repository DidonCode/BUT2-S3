<?php
	function printMessage($messageData, $receiverId, $addView){
		$htmlData = "";

        if(count($messageData) > 0){
            $lastDate = $messageData[0]['date'];
        }

        for($i = 0; $i < count($messageData); $i++){

            $hoursResult = dateDiffBetweenNumber($lastDate, $messageData[$i]['date']);
            $dayResult = dateDiffBetweenNumber($lastDate, getActuallyDate());

            if($hoursResult >= 3600){
                $date = "";
                if($dayResult >= 86400){
                    $date = $messageData[$i]['date'];
                }else{
                    $date = explode(" ", $messageData[$i]['date']);
                    $date = $date[0]; 
                }
                
                $htmlData .= '
                <div class="message-date">
                    <p>'.$date.'</p>
                </div>'; 

                $lastDate = $messageData[$i]['date'];
            }

            if($messageData[$i]['receiver'] == $receiverId){
                $htmlData .= '
                <div class="message-receiver">
                    <p class="message-message" name="'.$messageData[$i]['date'].'">'.htmlspecialchars($messageData[$i]['message']).'</p>
                </div>';
                if($addView && $messageData[$i]['view'] == 1 && $i == count($messageData) - 1){
                    $htmlData .=  '
                    <div class="message-view">
                        <p>Vu</p>
                    </div>';
                }
            }else{
                $htmlData .= '
                <div class="message-sender">
                    <p class="message-message" name="'.$messageData[$i]['date'].'">'.htmlspecialchars($messageData[$i]['message']).'</p>
                </div>';
            }
        }

        return $htmlData;
	}

?>