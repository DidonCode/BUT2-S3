<?php
		
	function generateValidationPopup($message){
		$htmlData = '
		<div class="popup-background">
			<div class="popup">
			    <div class="popup-content">
			    	<svg viewBox="0 0 256 256">
                        <defs>
                            <linearGradient id="gradientt" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color: var(--yellow-logo); stop-opacity: 1" />
                                <stop offset="100%" style="stop-color: var(--purple-logo); stop-opacity: 1" />
                            </linearGradient>
                        </defs>
                        <g transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
                        <path d="M 42.933 61.058 c -0.019 0 -0.037 0 -0.056 -0.001 c -0.55 -0.016 -1.069 -0.256 -1.435 -0.666 L 24.076 40.958 c -0.736 -0.824 -0.665 -2.088 0.159 -2.824 c 0.824 -0.734 2.087 -0.666 2.824 0.159 l 15.956 17.855 l 43.572 -43.571 c 0.781 -0.781 2.047 -0.781 2.828 0 c 0.781 0.781 0.781 2.047 0 2.828 L 44.347 60.472 C 43.971 60.848 43.462 61.058 42.933 61.058 z" transform=" matrix(1 0 0 1 0 0) " fill="url(#gradientt)" stroke-linecap="round" />
                        <path d="M 45 90 C 20.187 90 0 69.813 0 45 C 0 20.187 20.187 0 45 0 c 1.104 0 2 0.896 2 2 s -0.896 2 -2 2 C 22.393 4 4 22.393 4 45 s 18.393 41 41 41 s 41 -18.393 41 -41 c 0 -1.104 0.896 -2 2 -2 s 2 0.896 2 2 C 90 69.813 69.813 90 45 90 z" transform=" matrix(1 0 0 1 0 0) " fill="url(#gradientt)" stroke-linecap="round" />
                        </g>
                    </svg>
			        <p>'.$message.'</p>
			        <button class="popup-button-action" onclick="document.body.removeChild(document.getElementsByClassName(\'popup-background\')[0]); location.reload();">D\'accord</button>
			    </div>
			</div>
		</div>';

		return $htmlData;
	}

	function generateErrorPopup($message){
		$htmlData = '
		<div class="popup-background">
			<div class="popup">
			    <div class="popup-content">
			        <p style="color: red;">Error: '.$message.'</p>
			        <button class="popup-button-action" onclick="document.body.removeChild(document.getElementsByClassName(\'popup-background\')[0]); location.reload();">D\'accord</button>
			    </div>
			</div>
		</div>';

		return $htmlData;
	}
?>