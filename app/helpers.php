<?php

function BloodGroupFunction($value)
{
	if (empty($value)) {
		return trans('N/A');
	}

	$arrayName = [1=>'A+',2=> 'A-',3=> 'B+',4=> 'B-',5=> 'O+', 6=>'O-',7=>'AB+',8=>'AB-'];
	return $arrayName[$value];
}

function PriorityFunction($value=0)
{
	if (empty($value)) {
		return trans('N/A');
	}

	$arrayName = ['1'=>trans('Normal'),'2'=>trans('Urgent'),'3'=>trans('Emergency'),'4'=>trans('Critical')];
	return $arrayName[$value];
}
function StatusFunction($value)
{
	if (empty($value)) {
		return trans('N/A');
	}

	$arrayName = [1=>trans('New Request'),2=>trans('Active'),3=>trans('Being Reviewd'),4=>trans('Accepted'),5=>trans('Closed')];
	return $arrayName[$value];
}

// Return type of donation user is requesting.
function TypeFunction($value)
{
	if (empty($value)) {
		return trans('N/A');
	}

	$arrayName = [1 => trans('Whole Blood'),2=>trans('Plazma')];
	return $arrayName[$value];
}
// Return array of Comment Request type desctiprion, plasma and rbc will be added in future.
function CommentRequestTypeFunction($value)
{
	if (empty($value)) {
		return trans('N/A');
	}
	
	$arrayName =[1=>trans('Blood Donation Request')];
	return $arrayName[$value];
}
// Return requisition Seo Image link
function RequisitionSeoImgFunction($value = 1)
{
	$arrayName = array(
		1 => asset('images/A_plus_donor.png'),
		2 => asset('images/A_neg_donor.png'),
		3 => asset('images/B_plus_donor.png'),
		4 => asset('images/B_neg_donor.png'),
		5 => asset('images/O_plus_donor.png'),
		6 => asset('images/O_neg_donor.png'),
		7 => asset('images/AB_plus_donor.png'),
		8 => asset('images/AB_neg_donor.png'),
	 );
	if (empty($value)) {
		return trans('N/A');
	}
		return $arrayName[$value];
	
	
}