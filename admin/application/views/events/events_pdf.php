<?php

$html = '
		<h3>Events List</h3>
		<table border="1" style="width:100%">
			<thead>
				<tr class="headerrow">
					<th>Name</th>
					<th>Sort Description</th>
					<th>Event Date</th>
					<th>Event Locaton</th>
					<th>Event Time</th>
					<th>Created Date</th>
				</tr>
			</thead>
			<tbody>';

			foreach($all_events as $row):
			$html .= '		
				<tr class="oddrow">
					<td>'.$row['name'].'</td>
					<td>'.$row['sort_description'].'</td>
					<td>'.$row['event_date'].'</td>
					<td>'.$row['event_location'].'</td>
					<td>'.$row['event_time'].'</td>
					<td>'.$row['created_at'].'</td>
				</tr>';
			endforeach;

			$html .=	'</tbody>
			</table>			
		 ';
				
		$mpdf = new mPDF('c');

		$mpdf->SetProtection(array('print'));
		$mpdf->SetTitle("Admin - Event List");
		$mpdf->SetAuthor("AYT");
		$mpdf->watermark_font = 'AYT';
		$mpdf->watermarkTextAlpha = 0.1;
		$mpdf->SetDisplayMode('fullpage');		 
		 

		$mpdf->WriteHTML($html);

		$filename = 'event_list1';

		ob_clean();

		$mpdf->Output($filename . '.pdf', 'D');

		exit();

?>