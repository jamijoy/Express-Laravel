<?php

namespace App\Http\Controllers\AccountManagerControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Validator;
use PDF;

class AutomatedController extends Controller
{
    public function Index($num, Request $request){
        
		// $fname1 = array('Alamin','Rana','Protap','Rangsor','Adele','Stephan','Haward','Hawkings','Kajal','Hars','Agarwal','Tom','Donald','Cruise','Trump','Abrahamn','Barak','Lincoln','Obama','Micheal','Rodrique','Habibul','Khan','Kashif','Rana','Chouwdhury','Akram','Yunus','Ali','Harold','Mike','Chansie','Chan','Jakie','Masum','Pari','Growwal','Kapil','Akash','Rahman','Rowan','Atkinson','Kooper','Lara','Brand','Silvania');
		// $fname2 = array('Kajal','Hars','Agarwal','Tom','Donald','Cruise','Trump','Abrahamn','Barak','Lincoln','Obama','Micheal','Rodrique','Habibul','Khan','Kashif','Rana','Chouwdhury','Akram','Yunus','Ali','Harold','Mike','Chansie','Chan','Jakie','Masum','Pari','Growwal','Kapil','Akash','Rahman','Rowan','Atkinson','Kooper','Lara','Brand','Silvania','Alamin','Rana','Protap','Rangsor','Adele','Stephan','Haward','Hawkings');
		// $lname1 = array('Chandler','Bong','Bing','Monica','Galler','Ross','Joey','Tribbiani','Rachel','Green','Pheobe','Buffay','Kate','William','Williamson','Casper','Ballick','Khan','Ranold','Rahman','Khandokar','Sultan','Kedar','Jami','Shahrukh','Flamingh','Nazim','Vuiyan','Kapoor','Nickie','Minaj','Ruth','Tom','Rina','Kher','Masan','Sharma','Datt','Jimmy','Fallen','Alan','Walker','Abul','Hayat','Vickey','Singhania');
		// $lname2 = array('Tribbiani','Rachel','Green','Pheobe','Buffay','Kate','William','Williamson','Casper','Ballick','Khan','Ranold','Chandler','Bong','Bing','Monica','Galler','Kher','Masan','Sharma','Datt','Jimmy','Fallen','Alan','Walker','Abul','Hayat','Vickey','Singhania','Ross','Joey','Rahman','Khandokar','Sultan','Kedar','Jami','Shahrukh','Flamingh','Nazim','Vuiyan','Kapoor','Nickie','Minaj','Ruth','Tom','Rina');
		// $email1 = array('@gmail.com','@outlook.com','@live.com','@yahoo.com','@hotmail.com','@express.com','@aiub.edu','@gov.bd','@facebook.com','@onelive.com','@foundings.org','@auctionAction.com','@Hollowin.com','@ymail.com','@laravel.com');
		
		$fname1 = DB::table('mock_data')->select('first_name')->get();
		$lname1 = DB::table('mock_data')->select('last_name')->get();
		$email1 = DB::table('mock_data')->select('email')->get();
		$addrs1 = array('C Adams Lane, Andorra La Vella, Andorra','D Jackson Height st.,Saint Johns,Antigua ','F Liverpool Playyard,Buenos Aires,Argentina','A Yanbkshi Road,Canberra,Australia','D Lakveil Graveyard,Vienna,Austria','D Dankan Street,Manama,Bahrain','E Makentile Fort Road, Brasilia, Brazil.','A Albert Graham Road, Bandar Seri Begawan, Brunei.','C Lorial Grafens Road, Ottawa, Canada.','A Eskaton Road,Santiago, Chile.','B HardGain Road, Beijing, China.','K Serambag st.San Jose, Costa Rica.','E Idia Gate, Havana,Cuba. ','F Loganham Palace, Prague, Czechia.','A Californian St. Copenhagen, Denmark.','D Arter Rolen Road, Cairo, Egypt.','C Eskaton Palace Road, San Salvador, El Salvador.','B Cilliam Transmit Road, Helsinki, Finland.','F Billiard Road Fort Gate, Paris, France.','C Delta Prime Hospital Road, Berlin, Germany','M Royal Palace, Green Garden , Athens, Greece.','H Edward Field Residence, Saint Georges, Grenada.','E Sylvania Towar, Dhakeshwari, Dhaka, Bangladesh.','T Merul Badda Road, Dhaka, Bangladesh','D Citizen Square, Budapest, Hungary.','H Tokyo Square, Kermail, Tokyo, Japan.','J Lorenham Palace, Tehran, Iran.','M Resavoir Palace, Baghdad, Iraq.','R Beikstone Georgia, Rome, Italy.','G White House Residence, Kingston, Jamaica.','H Washinton View Fort Gate, Kuwait City, Kuwait.','D Norveil Tower, Tripoli, Libya.','H Oscean View Lane, Panama City, Panama.','T ARB Apartment, Monaco, Monaco.');
		$post = DB::table('postdata')->get();
		
		for($i=1 ; $i<$num+1; $i++)
		{
			if($i%6==0)
			{
				$fname = $fname1[rand(0,999)]->first_name;
				$lname = $lname1[rand(0,999)]->last_name;
				$sex = 'male';
				$mon = '0'.rand(1,9);
				$day = rand(10,31);
				$usr = 'post.manager';
				$sts = 'Activated';
			}
			else if($i%3==0)
			{
				$fname = $fname1[rand(0,999)]->first_name;
				$lname = $lname1[rand(0,999)]->last_name;
				$sex = 'male';
				$mon = '0'.rand(1,9);
				$day = '0'.rand(1,9);
				$usr = 'account.manager';
				$sts = 'Activated';
			}
			else if($i%2==0)
			{
				$fname = $fname1[rand(0,999)]->first_name;
				$lname = $lname1[rand(0,999)]->last_name;
				$sex = 'male';
				$mon = rand(10,12);
				$day = rand(10,31);
				$usr = 'user';
				$sts = 'Activated';
			}
			else
			{
				$fname = $fname1[rand(0,999)]->first_name;
				$lname = $lname1[rand(0,999)]->last_name;
				$sex = 'female';
				$mon = rand(10,12);
				$day = '0'.rand(1,9);
				$usr = 'user';
				$sts = 'Deactivated';
			}
			
			echo $i.".<br/>";
			echo "first_name".$fname;
			echo "last_name".$lname;
			$username = $fname.$lname;
			echo "user_name".$fname." ".$lname."<br/>";
			// $mail= $fname.".".$lname.rand(1950,2020).$email1[rand(0,14)];
			$mail= $email1[rand(0,999)]->email;
			echo "Email : ".$mail."<br/>";
			$webArr = explode("@",$mail);
			echo "Website : www.".$webArr[1]."<br/>";
			echo "password : ".$fname."<br/>";
			$phn = rand(999,99999)+rand(999,99999);
			$phone = rand(111,999)."-".$phn;
			echo "phone : ".$phone."<br/>";
			echo "gender : ".$sex."<br/>";
			$bday = rand(1950,2002)."-".$mon."-".$day;
			$bio = $post[rand(0,150)]->data;
			echo "birthdate : ".rand(1950,2002)."-".$mon."-".$day."<br/>";
			echo "bio : ".$bio."<br/>";
			$address = rand(10,99)."/".rand(10,99).$addrs1[rand(0,33)];
			echo "bio : ".$address."<br/>";
			
			$status1= DB::table('user_login')->insert([
					'user_id'	=> null,
					'username'	=> $username,
					'email'  	=> $mail,
					'password'  => $fname
					]);
					
			$id = DB::table('user_login')->where('username',$username)->value('user_id');
								
			$status2= DB::table('user_details')->insert([
					'user_id'		=> $id,
					'first_name'	=> $fname,
					'last_name'		=> $lname,
					'phone'			=> $phone,
					'gender'		=> $sex,
					'birthdate'		=> $bday,
					'bio'			=> $bio,
					'address'		=> $address,
					'user_type'		=> $usr,
					'account_status'=> $sts,
				]);
		}
    }
	
	public function Posts($num, Request $request){
        
		$uid = DB::table('user_details')->get();
		$post = DB::table('postdata')->get();
		$type1   = array('private','public');
		$status1 = array('Disapproved','Approved');
		
		
		for($i=1 ; $i<$num+1; $i++)
		{
			if($i%3==0){
				$st = $status1[0];
			}else{
				$st = $status1[1];
			}
			
			if($i%6==0){
				$ty = $type1[0];
			}else{
				$ty = $type1[1];
			}
			
			echo $i.".<br/>";
			$udi = $uid[rand(20,218)]->user_id;
			echo $udi."<br/>";
			echo $ty."<br/>";
			echo $st."<br/>";
			$pt = "2020"."-02-0".rand(1,9)." 0".rand(1,9).":".rand(10,59);
			echo $pt."<br/>";
			$data = $post[rand(0,179)]->data;
			echo $data."<br/>";
			
			
			
			// $status = DB::table('post_details')
					// ->insert([  'post_id'     => Null,
								// 'user_id'	  => $udi,
								// 'post_text'	  => $data,
								// 'post_type'   => $ty,
								// 'post_status' => $st,
								// 'post_time'   => $pt
								// ]);
		}
    }
	
	public function DeletePosts(Request $request){
        
		$uid = DB::table('user_details')->get();
		$post = DB::table('post_details')->where('post_time','like','2020-05%')->orderBy('post_time')->get();
		$type1   = array('private','public');
		$status1 = array('Disapproved','Approved');
		
		
		for($i=0 ; $i<count($post); $i++)
		{
			echo $i.">".$post[$i]->post_id .">".$post[$i]->post_time ."<br/>";
		}
		
		// $do = DB::table('post_details')->where('post_time','like','2020-05-3%')->delete();
    }
	
	public function ChangeDate(Request $request){
        
		$post = DB::table('post_details')->get();
		
		$cnt=0;
		for($i=0 ; $i<count($post); $i++)
		{
			$timeArray = explode(" ",$post[$i]->post_time);
			
			$dateArray = explode("-",$timeArray[0]);
			
			// echo $post[$i]->post_id." : ".$post[$i]->post_time." > ".$dateArray[0]." >> ".$dateArray[1]." >> ".$dateArray[2]." <br/> ";
			// echo " New Date > ".$dateArray[2]."-".$dateArray[1]."-".$dateArray[0]." ".$timeArray[1]." >> ".$post[$i]->post_id." <br/> ";
			
			if($dateArray[0] != '2020')
			{
				$newDate = $dateArray[2]."-".$dateArray[1]."-".$dateArray[0]." ".$timeArray[1];
				// $cnt = $cnt + 1;
				// echo $cnt.">".$newDate."<br/>";
				// $updateDate = DB::table('post_details')
							// ->where('post_id',$post[$i]->post_id)
							// ->update(['post_time'=>$newDate]);
			}
			
			
		}
		echo "done";
    }
}
