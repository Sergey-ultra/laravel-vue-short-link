<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LinkController extends Controller
{
    public function link(Request $request){
         $link = Link::where('code', $request->short_link)->first();
         if ($link){
            return $link->link;
       }
        return response()->json(['message' => 'Link not found']);
    }

    public function index(Request $request)
    {
        return $links = Link::where('user_id', $request->user()->id)->latest()->paginate(10);
    }

    public function store(Request $request)
    {
        $request->validate([
            'link' => 'required|url',

        ]);
        $existingLink = Link::where('link', $request->link)->first();

        if ($existingLink){
            return  response()->json([
                'message'=> 'Link already exist',
                'status' => false
            ]);
        }
        function crypto_rand_secure($min, $max)
        {
            $range = $max - $min;
            if ($range < 1) return $min; // not so random...
            $log = ceil(log($range, 2));
            $bytes = (int) ($log / 8) + 1; // length in bytes
            $bits = (int) $log + 1; // length in bits
            $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
            do {
                $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
                $rnd = $rnd & $filter; // discard irrelevant bits
            } while ($rnd > $range);
            return $min + $rnd;
        }

        function getToken($length)
        {
            $token = "";
            $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
            $codeAlphabet.= "0123456789";
            $max = strlen($codeAlphabet); // edited

            for ($i=0; $i < $length; $i++) {
                $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
            }

            return $token;
        }



        Link::create([
            'link' => $request->link,
            'code' => '/go/' . getToken(8),
            'user_id' => $request->user()->id
        ]);

        return response()->json([
            'message' => 'short link was created',
            'status' => true
        ]);
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $existingLink = Link::find($id);
        if ($existingLink)
        {
            $existingLink->delete();
            return "Link successfully deleted";
        }
        return "Link not found";
    }
}
