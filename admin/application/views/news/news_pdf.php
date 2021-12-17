<?php

$html = '
		<h3>Newss List</h3>
		<table border="1" style="width:100%">
			<thead>
				<tr class="headerrow">
					<th>Name</th>
					<th>Sort Description</th>
					<th>News Date</th>
					<th>News Locaton</th>
					<th>News Time</th>
					<th>Created Date</th>
				</tr>
			</thead>
			<tbody>';

			foreach($all_news as $row):
			$html .= '		
				<tr class="oddrow">
					<td>'.$row['name'].'</td>
					<td>'.$row['sort_description'].'</td>
					<td>'.$row['news_date'].'</td>
					<td>'.$row['news_location'].'</td>
					<td>'.$row['news_time'].'</td>
					<td>'.$row['created_at'].'</td>
				</tr>';
			endforeach;

			$html .=	'</tbody>
			</table>			
		 ';
				
		$mpdf = new mPDF('c');

		$mpdf->SetProtection(array('print'));
		$mpdf->SetTitle("Admin - News List");
		$mpdf->SetAuthor("AYT");
		$mpdf->watermark_font = 'AYT';
		$mpdf->watermarkTextAlpha = 0.1;
		$mpdf->SetDisplayMode('fullpage');		 
		 

		$mpdf->WriteHTML($html);

		$filename = 'news_list1';

		ob_clean();

		$mpdf->Output($filename . '.pdf', 'D');

		exit();

?>