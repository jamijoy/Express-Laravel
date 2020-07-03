<?php

namespace App\Http\Controllers\AccountManagerControllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

use PDF;

class AcmReportController extends Controller
{
    public function Index($searchBy, Request $request){
		
        if($request->session()->has('user_id') && $request->session()->has('acmStatus')){

            $user = DB::table('user_details')
                        ->where('user_id', $request->session()->get('user_id'))
                        ->first();
			
			$data = DB::table('account_warning')
						->rightJoin('user_details','user_details.user_id','=','account_warning.user_id')
						->orderBy('user_details.user_id')
						->get();
						
			$blockData = DB::table('account_block_request')->get();
			
			
			if($searchBy=='Followers')
			{
				$followerData = DB::table('user_follower')
									->select(DB::raw('count(*) as followers, user_id'))
									->groupBy('user_id')
									->get();
				return view('AccountManagerViews.report', ['user' => $user,'data' => $data,'blockData' => $blockData,'followerData' => $followerData,'reportState' => $searchBy]);
			}
			else if($searchBy=='Accounts')
			{
				$data = DB::table('account_warning')
						->rightJoin('user_details','user_details.user_id','=','account_warning.user_id')
						->orderBy('user_details.first_name')
						->get();
				return view('AccountManagerViews.report', ['user' => $user,'data' => $data,'blockData' => $blockData,'reportState' => $searchBy]);
			}
			else if($searchBy=='Warnings')
			{
				$data = DB::table('account_warning')
						->rightJoin('user_details','user_details.user_id','=','account_warning.user_id')
						->orderBy('account_warning.warning_count','desc')
						->get();
				return view('AccountManagerViews.report', ['user' => $user,'data' => $data,'blockData' => $blockData,'reportState' => $searchBy]);
			}
			else if($searchBy=='Actives')
			{
				$data = DB::table('account_warning')
						->rightJoin('user_details','user_details.user_id','=','account_warning.user_id')
						->where('user_details.account_status','Activated')
						->orderBy('user_details.user_id')
						->get();
				return view('AccountManagerViews.report', ['user' => $user,'data' => $data,'blockData' => $blockData,'reportState' => $searchBy]);
			}
			else if($searchBy=='Inactives')
			{
				$data = DB::table('account_warning')
						->rightJoin('user_details','user_details.user_id','=','account_warning.user_id')
						->where('user_details.account_status','Deactivated')
						->orderBy('user_details.user_id')
						->get();
				return view('AccountManagerViews.report', ['user' => $user,'data' => $data,'blockData' => $blockData,'reportState' => $searchBy]);
			}
			else if($searchBy=='Blocks')
			{
				$data = DB::table('account_warning')
						->rightJoin('user_details','user_details.user_id','=','account_warning.user_id')
						->leftJoin('account_block_request','user_details.user_id','=','account_block_request.user_id')
						->where('account_block_request.block_status','Blocked')
						->orderBy('user_details.user_id')
						->get();
				return view('AccountManagerViews.report', ['user' => $user,'data' => $data,'blockData' => $blockData,'reportState' => $searchBy]);
			}
			else if($searchBy=='Pendings')
			{
				$data = DB::table('account_warning')
						->rightJoin('user_details','user_details.user_id','=','account_warning.user_id')
						->leftJoin('account_block_request','user_details.user_id','=','account_block_request.user_id')
						->where('account_block_request.block_status','Pending')
						->orderBy('user_details.user_id')
						->get();
				return view('AccountManagerViews.report', ['user' => $user,'data' => $data,'blockData' => $blockData,'reportState' => $searchBy]);
			}
			else if($searchBy=='Acms')
			{
				$data = DB::table('account_warning')
						->rightJoin('user_details','user_details.user_id','=','account_warning.user_id')
						->where('user_details.user_type','account.manager')
						->orderBy('user_details.user_id')
						->get();
				return view('AccountManagerViews.report', ['user' => $user,'data' => $data,'blockData' => $blockData,'reportState' => $searchBy]);
			}
			else if($searchBy=='Pcms')
			{
				$data = DB::table('account_warning')
						->rightJoin('user_details','user_details.user_id','=','account_warning.user_id')
						->where('user_details.user_type','post.manager')
						->orderBy('user_details.user_id')
						->get();
				return view('AccountManagerViews.report', ['user' => $user,'data' => $data,'blockData' => $blockData,'reportState' => $searchBy]);
			}
			else if($searchBy=='Users')
			{
				$data = DB::table('account_warning')
						->rightJoin('user_details','user_details.user_id','=','account_warning.user_id')
						->where('user_details.user_type','user')
						->orderBy('user_details.user_id')
						->get();
				return view('AccountManagerViews.report', ['user' => $user,'data' => $data,'blockData' => $blockData,'reportState' => $searchBy]);
			}
			else
			{
				return view('AccountManagerViews.report', ['user' => $user,'data' => $data,'blockData' => $blockData,'reportState' => $searchBy]);
			}
			
			
			
            
        }
        else{
            return redirect('/logout');
        }
    }
	
	public function Download($searchBy, Request $request){
		
		if($request->session()->has('user_id') && $request->session()->has('acmStatus')){

            $user = DB::table('user_details')
                        ->where('user_id', $request->session()->get('user_id'))
                        ->first();
			
			$data = DB::table('account_warning')
						->rightJoin('user_details','user_details.user_id','=','account_warning.user_id')
						->orderBy('user_details.user_id')
						->get();
						
			$blockData = DB::table('account_block_request')->get();
			
			$timeTrack = 'ACM Report '.Date('yy-m-d g:i');
			
			$reportState = $searchBy;
			
			if($searchBy=='Followers')
			{
				$followerData = DB::table('user_follower')
									->select(DB::raw('count(*) as followers, user_id'))
									->groupBy('user_id')
									->get();
				
				$pdf = PDF::loadView('AccountManagerViews.download', compact('user','data','blockData','followerData','reportState'));
				return $pdf->download($timeTrack.'.pdf');
			}
			else if($searchBy=='Accounts')
			{
				$data = DB::table('account_warning')
						->rightJoin('user_details','user_details.user_id','=','account_warning.user_id')
						->orderBy('user_details.first_name')
						->get();
				
				$pdf = PDF::loadView('AccountManagerViews.download', compact('user','data','blockData','reportState'));
				return $pdf->download($timeTrack.'.pdf');
			}
			else if($searchBy=='Warnings')
			{
				$data = DB::table('account_warning')
						->rightJoin('user_details','user_details.user_id','=','account_warning.user_id')
						->orderBy('account_warning.warning_count','desc')
						->get();
				
				$pdf = PDF::loadView('AccountManagerViews.download', compact('user','data','blockData','reportState'));
				return $pdf->download($timeTrack.'.pdf');
			}
			else if($searchBy=='Actives')
			{
				$data = DB::table('account_warning')
						->rightJoin('user_details','user_details.user_id','=','account_warning.user_id')
						->where('user_details.account_status','Activated')
						->orderBy('user_details.user_id')
						->get();
				
				$pdf = PDF::loadView('AccountManagerViews.download', compact('user','data','blockData','reportState'));
				return $pdf->download($timeTrack.'.pdf');
			}
			else if($searchBy=='Inactives')
			{
				$data = DB::table('account_warning')
						->rightJoin('user_details','user_details.user_id','=','account_warning.user_id')
						->where('user_details.account_status','Deactivated')
						->orderBy('user_details.user_id')
						->get();
				
				$pdf = PDF::loadView('AccountManagerViews.download', compact('user','data','blockData','reportState'));
				return $pdf->download($timeTrack.'.pdf');
			}
			else if($searchBy=='Blocks')
			{
				$data = DB::table('account_warning')
						->rightJoin('user_details','user_details.user_id','=','account_warning.user_id')
						->leftJoin('account_block_request','user_details.user_id','=','account_block_request.user_id')
						->where('account_block_request.block_status','Blocked')
						->orderBy('user_details.user_id')
						->get();
				
				$pdf = PDF::loadView('AccountManagerViews.download', compact('user','data','blockData','reportState'));
				return $pdf->download($timeTrack.'.pdf');
			}
			else if($searchBy=='Pendings')
			{
				$reportState = $searchBy;
				
				$data = DB::table('account_warning')
						->rightJoin('user_details','user_details.user_id','=','account_warning.user_id')
						->leftJoin('account_block_request','user_details.user_id','=','account_block_request.user_id')
						->where('account_block_request.block_status','Pending')
						->orderBy('user_details.user_id')
						->get();
				
				$pdf = PDF::loadView('AccountManagerViews.download', compact('user','data','blockData','reportState'));
				return $pdf->download($timeTrack.'.pdf');
			}
			else if($searchBy=='Acms')
			{
				$data = DB::table('account_warning')
						->rightJoin('user_details','user_details.user_id','=','account_warning.user_id')
						->where('user_details.user_type','account.manager')
						->orderBy('user_details.user_id')
						->get();
				
				$pdf = PDF::loadView('AccountManagerViews.download', compact('user','data','blockData','reportState'));
				return $pdf->download($timeTrack.'.pdf');
			}
			else if($searchBy=='Pcms')
			{
				$data = DB::table('account_warning')
						->rightJoin('user_details','user_details.user_id','=','account_warning.user_id')
						->where('user_details.user_type','post.manager')
						->orderBy('user_details.user_id')
						->get();
				
				$pdf = PDF::loadView('AccountManagerViews.download', compact('user','data','blockData','reportState'));
				return $pdf->download($timeTrack.'.pdf');
			}
			else if($searchBy=='Users')
			{
				$data = DB::table('account_warning')
						->rightJoin('user_details','user_details.user_id','=','account_warning.user_id')
						->where('user_details.user_type','user')
						->orderBy('user_details.user_id')
						->get();
				
				$pdf = PDF::loadView('AccountManagerViews.download', compact('user','data','blockData','reportState'));
				return $pdf->download($timeTrack.'.pdf');
			}
			else
			{
				$pdf = PDF::loadView('AccountManagerViews.download', compact('user','data','blockData','reportState'));
				return $pdf->download($timeTrack.'.pdf');
			}
			
			
			
            
        }
        else{
            return redirect('/logout');
        }
	}
	
	public function AdvSearch(Request $request){
		
		$data = DB::table('account_warning')
					->rightJoin('user_details','user_details.user_id','=','account_warning.user_id')
					->where('user_details.first_name','like','%'.$request->keyword.'%')
					->orWhere('user_details.last_name','like','%'.$request->keyword.'%')
					->orderBy('user_details.user_id')
					->get();
					
		$blockData = DB::table('account_block_request')->get();
		
		$msi='';
		$msg = '<table border="1px" width="100%">
					<tr>
						<th class="center-text">User ID</th>
						<th class="name-text">Name</th>
						<th class="center-text">Warnings</th>
						<th class="center-text">Account Status</th>
						<th class="center-text">Block Status</th>
					</tr>';
				foreach($data as $dt){
					$classVal='';
					if($dt->user_type!='user'){
						$classVal='manager-row';}
					$ctt=0;
					$bck='';
					foreach($blockData as $blocks){
						if($dt->user_id == $blocks->user_id){
							$ctt=1;
							if($blocks->block_status=='Blocked'){
								$bck='<input type="button" onclick="Unblocker('.$dt->user_id.')" class="deny-button" value="'.$blocks->block_status.'">';}
							else{
								$bck='<input type="button" onclick="Blocker('.$dt->user_id.')" class="pending-button" value="Unblocked">';}}}
					if($ctt==0){
						$bck='<input type="button" onclick="Blocker('.$dt->user_id.')" class="approve-button" value="Unblocked">';}
					$stss='';
					if($dt->account_status=='Activated'){
						$stss="<a class='approve-button'>".$dt->account_status."</a>";}
					else{
						$stss="<a class='deny-button'>".$dt->account_status."</a>";}
					$dt->user_id;
					$dta='Haya';
					$ms = ' <tr>
								<td class="center-text">'.$dt->user_id.'</td>
								<td class="name-text"><a href="/AccountManager/UserProfile/'.$dt->user_id.'">'.$dt->first_name.' '.$dt->last_name.'</a></td>
								<td class="center-text">'.$dt->warning_count.'</td>
								<td class="center-text">'.$stss.'</td>
								<td class="center-text">'.$bck.'</td>
							</tr>';
					$msi = $msi.$ms;}
		$msg = $msg.$msi.'</table>';
		return response()->json(array('msg'=>$msg),200);
		
	}
}
