<?php

$html = '
		<h3>Testimonial List</h3>
		<table border="1" style="width:100%">
			<thead>
				<tr class="headerrow"> 
					<th>Name</th>
					<th>Designation</th>
					<th>Message</th> 
					<th>Created Date</th>
				</tr>
			</thead>
			<tbody>';

			foreach($all_testimonials as $row):
			$html .= '		
				<tr class="oddrow"> 
					<td>'.$row['name'].'</td>
					<td>'.$row['designation'].'</td>
					<td>'.$row['message'].'</td> 
					<td>'.$row['created_at'].'</td>
				</tr>';
			endforeach;

			$html .=	'</tbody>
			</table>			
		 ';
		 	
		$mpdf = new mPDF('c');

		$mpdf->SetProtection(array('print'));
		$mpdf->SetTitle("Admin - Testimonial List");
		$mpdf->SetAuthor("AYT");
		$mpdf->watermark_font = 'AYT';
		$mpdf->watermarkTextAlpha = 0.1;
		$mpdf->SetDisplayMode('fullpage');		 
		 

		$mpdf->WriteHTML($html);

		$filename = 'testimonial_list1';

		ob_clean();

		$mpdf->Output($filename . '.pdf', 'D');

		exit();

?>