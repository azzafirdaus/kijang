<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth, Validator, Input; 
use App\User;
use App\Periode;
use App\TransaksiBar3;
use App\Item3;
use App\Gelang;

class Bar3Controller extends Controller {

	//

	public function barMenu(){
		
		if(Auth::check()){
             $id = Auth::user()->id; 
            
            $role = User::getRoles($id);
            
            if ($role == "bar") {
            $data = array();
            $data1 = array();
			return view('bar3Menu')
                ->with('transaksiBar1', $data)
                ->with('transaksiBar2', $data1);
            }
	}
		return redirect('/auth/bar3Login')->with('loginError', 'Please login first!');
	}
        
	public function barPrint(){
        
            $result1 = Input::get('result1');
            $result2 = Input::get('result2');
        
        
        
        return view('bar3PreMenu')->with('success', 'Transaksi bar berhasil');
	}

	public function login(){
		
		return view('/auth/bar3Login');
	}

	public function logout(){
		
		Auth::logout();
		return view('/auth/bar3Login');
	}


	public function loginProcess(){
		
		$rules = array(
			'username' => 'required',			
			'password' => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);


		if($validator->fails()){

			return redirect('auth/bar3Login')->withErrors($validator);
		}

		$user = array(
			'username' => Input::get('username'),
			'password' => Input::get('password') 
		);

		if(Auth::attempt($user)){
            
            $role = User::getRole(Input::get('username'));
            
            if ($role == "bar") {
//                $data = array();
//                $data1 = array();
                return view('bar3PreMenu')->with('success', '');
//			     return view('bar3Menu')
//                ->with('transaksiBar1', $data)
//                ->with('transaksiBar2', $data1);
            }
		}

		return redirect('auth/bar3Login')->with('loginError', 'Wrong username or password');
	}
    
    public function add() {
        if(Periode::activeExist() == 1) {
            
            $rules = array(
			     'id' => 'required',			
			     'jumlahItem' => 'required',
			     'noGelang' => 'required'
		    );
            
            $validator = Validator::make(Input::all(), $rules);


		    if($validator->fails()){

			     return redirect('bar3Menu')->withErrors($validator)->with('transaksiBar', $data);
		    }
            
            TransaksiBar3::add(Input::get('id'), Input::get('jumlahItem'), Input::get('noGelang'));
            
            
            $transaksiBar = TransaksiBar3::getTransaksi(Input::get('noGelang'));
            $total = 0;
            $data = array();
            foreach($transaksiBar as $transaksi) {
                array_push($data, 
                      [
                        'qty' => $transaksi->jumlah,
                        'isi' => Item3::getNama($transaksi->id_item) . ' @ ' . Item3::getPrice($transaksi->id_item),                      
                        'jumlah' => $transaksi->harga_total
                      ]
                      );
            $total += $transaksi->harga_total;
            }
            return view('bar3Invoice')
            ->with('transaksiBar', $data)
            ->with('totalTransaksiBar', $total)
            ->with('noKartu', Input::get('noGelang'));
        } else {
            return redirect('bar3Menu')->withErrors('Transaksi belum dibuka')->with('transaksiBar', $data);
        }   
    }
    
    public function delete() {
        $data = array();
        $data1 = array();
        $result1 = Input::get('result1');
        $result2 = Input::get('result2');
        if ($result1 != NULL) {
            $data = $result1;
            $data1 = $result2;
        }
        $id = Input::get('idArray')-2;
        unset($data[$id]);
        unset($data1[$id]);
            return view('bar3Menu')
                ->with('transaksiBar1', $data)
                ->with('transaksiBar2', $data1)
                ->with('noKartu', Input::get('noKartu'));
    }
    
    public function addOn() {
        if(Periode::activeExist() == 1) {
            
            $rules = array(
			     'id' => 'required',			
			     'jumlahItem' => 'required'
		    );
            
            $validator = Validator::make(Input::all(), $rules);


            $data = array();
            $data1 = array();
            $result1 = Input::get('result1');
            $result2 = Input::get('result2');
            if ($result1 != NULL) {
                $data = $result1;
                $data1 = $result2;
            }
            
		    if($validator->fails()){

			     return view('bar3Menu')->withErrors($validator)
                        ->with('transaksiBar1', $data)
                        ->with('transaksiBar2', $data1)
                        ->with('noKartu', Input::get('noKartu'));
		    }
            
            if(Item3::getNama(Input::get('id')) != NULL) {
                
                
                $indexnya = 0;
                    foreach ($data as $index => $isi) {
                        if ($isi == Item3::getNama(Input::get('id'))) {
                            if(Item3::getStock(Item3::getNama(Input::get('id'))) >= Input::get('jumlahItem') + $data1[$index]) {
                                $data1[$index] += Input::get('jumlahItem');
                                
                    return view('bar3Menu')
                        ->with('transaksiBar1', $data)
                        ->with('transaksiBar2', $data1)->with('noKartu', Input::get('noKartu'));
                            } else {
                                return view('bar3Menu')
                                ->with('transaksiBar1', $data)
                                ->with('transaksiBar2', $data1)->with('noKartu', Input::get('noKartu'))->withErrors('Stock item tidak mencukupi');
                            }
                        }
                    }
                
                
                
                
                
                
                
                
                
                if(Item3::getStock(Item3::getNama(Input::get('id'))) >= Input::get('jumlahItem')) {
                    array_push($data, Item3::getNama(Input::get('id')));
            
                    array_push($data1, Input::get('jumlahItem'));
            
                    return view('bar3Menu')
                        ->with('transaksiBar1', $data)
                        ->with('transaksiBar2', $data1)->with('noKartu', Input::get('noKartu'));
                } else {
                    return view('bar3Menu')
                    ->with('transaksiBar1', $data)
                    ->with('transaksiBar2', $data1)->with('noKartu', Input::get('noKartu'))->withErrors('Stock item tidak mencukupi');
                }
                
                
                
                
                
                
                
                
            } else {
                return view('bar3Menu')
                ->with('transaksiBar1', $data)
                ->with('transaksiBar2', $data1)->with('noKartu', Input::get('noKartu'))->withErrors('Id item tidak terdaftar');
            }
        } else {
            $data = array();
            $data1 = array();
            return view('bar3Menu')->withErrors('Transaksi belum dibuka')
                ->with('transaksiBar1', $data)
                ->with('transaksiBar2', $data1)->with('noKartu', Input::get('noKartu'));
        }   
    }
    
    public function backToBar() {
        
            $result1 = Input::get('result1');
            $result2 = Input::get('result2');
        
            $noKartu = Input::get('noKartu');
        
            
			return view('bar3Menu')
                ->with('transaksiBar1', $result1)
                ->with('transaksiBar2', $result2)
                ->with('noKartu', $noKartu);
            
    }
    
    public function cari(){

        return view('cariBar3')->with('noKartu', Input::get('noKartu'));
    }

    public function hasil_cari(){
        
        $rules = array(
            'noKartu' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);


        if($validator->fails()){

            return redirect('cariBar3')->withErrors($validator);
        }
        
        return view('hasilCariBar3')->with('saldo', Gelang::getSaldo(Input::get('noKartu')));
    }
    
        public function barPreMenu(){


        return view('bar3PreMenu')->with('success', '');
    }

    public function barPreMenuProcess(){

        $rules = array(
            'noKartu' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);


        if($validator->fails()){

            return redirect('bar3PreMenu')->withErrors($validator)->with('success', '');
        }

        $noKartu = Input::get('noKartu');
        
        if(Gelang::checkAvailable($noKartu) > 0){
            $data = array();
            $data1 = array();
            return view('bar3Menu')->with('transaksiBar1', $data)
                ->with('transaksiBar2', $data1)->with('noKartu', $noKartu);
        } else {
            return redirect('bar3PreMenu')->withErrors("No. Kartu belum dipakai")->with('success', '');
        }
    }

    public function cariPre(){

        return view('cariBar3Pre');
    }

    public function hasil_cariPre(){
        
        $rules = array(
            'noKartu' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);


        if($validator->fails()){

            return redirect('cariBar3Pre')->withErrors($validator);
        }
        
        return view('hasilCariBar3Pre')->with('saldo', Gelang::getSaldo(Input::get('noKartu')));
    }

    public function barInvoice(){

            $result1 = Input::get('result1');
            $result2 = Input::get('result2');

            if($result1 != ''){
        
                $total = 0;
                $all = array();
                foreach($result1 as $index => $isi) {
                    array_push($all, 
                          [
                            'qty' => $result2[$index],
                            'isi' => $isi . ' @ ' . Item3::getPriceWithName($isi),                      
                            'jumlah' => Item3::getPriceWithName($isi) * $result2[$index]
                          ]
                          );
                    $total += Item3::getPriceWithName($isi) * $result2[$index];
                }
            
                $saldo = Gelang::getSaldo(Input::get('noKartu'));
                $sisa = Gelang::getSaldo(Input::get('noKartu')) - $total;
                if($sisa < 0) {
                    return view('bar3Menu')->with('transaksiBar1', $result1)
                        ->with('transaksiBar2', $result2)->with('noKartu', Input::get('noKartu'))->withErrors('Saldo tidak mencukupi');
                }
                
                
                Gelang::minSaldo(Input::get('noKartu'), $total);
                
                
            foreach($result1 as $index => $isi) {
                Item3::minStock($isi, $result2[$index]);
                TransaksiBar3::add(Item3::getId($isi), $result2[$index], Input::get('noKartu'));
            }
                return view('bar3Invoice')->with('noKartu', Input::get('noKartu'))->with('transaksiBar', $all)->with('totalTransaksiBar', $total)
                        ->with('transaksiBar1', $result1)
                        ->with('transaksiBar2', $result2)
                        ->with('sisa' , Gelang::getSaldo(Input::get('noKartu')))
                        ->with('saldo', $saldo);
            }

            else{ 

                $data = array();
                $data1 = array();

                return view('bar3Menu')
                ->with('transaksiBar1', $data)
                ->with('transaksiBar2', $data1)
                ->with('noKartu', Input::get('noKartu'));
            }
    }

    public function stock_bar3(){
        return view('cashier.stock3')->with('itemList', Item3::all())->with('status', 'bar');
    }
}

