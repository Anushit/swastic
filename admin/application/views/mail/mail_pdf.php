<?php

$html = '
		<h3>Mail List</h3>
		<table border="1" style="width:100%">
			<thead>
				<tr class="headerrow"> 
					<th>id</th>
					<th>Subject</th> 
					<th>Message</th> 
					<th>Attachment</th> 
					<th>Created Date</th>
				</tr>
			</thead>
			<tbody>';

			foreach($all_mails as $row):
			$html .= '		
				<tr class="oddrow"> 
					<td>'.$row['id'].'</td>
					<td>'.$row['subject'].'</td> 
					<td>'.$row['message'].'</td> 
					<td>'.$row['attachment'].'</td> 
					<td>'.$row['created_at'].'</td>
				</tr>';
			endforeach;

			$html .=	'</tbody>
			</table>			
		 ';
				
		$mpdf = new mPDF('c');

		$mpdf->SetProtection(array('print'));
		$mpdf->SetTitle("Admin - Mail List");
		$mpdf->SetAuthor("AYT");
		$mpdf->watermark_font = 'AYT';
		$mpdf->watermarkTextAlpha = 0.1;
		$mpdf->SetDisplayMode('fullpage');		 
		 

		$mpdf->WriteHTML($html);

		$filename = 'Mail_list1';

		ob_clean();

		$mpdf->Output($filename . '.pdf', 'D');

		exit();

?>