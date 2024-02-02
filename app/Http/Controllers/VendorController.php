<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Location;
use App\Models\AgreementDetail;
use App\Models\ContactPersonDetail;
use Validator;

class VendorController extends Controller
{
    public function vendorList(Request $request)
    {
        $all_vendors = Vendor::all();
        $response = [
            'success' => true,
            'data'=>$all_vendors
        ];
        return response()->json($response);
    }
    public function getVendor(Request $request,$vendorId)
    {
        $all_vendors = Vendor::where('id',$vendorId);
        if($all_vendors->count()  == 0){

            $response = [
                'success' => false,
                'error'=>'Invalid Vendor Id'
            ];
            return response()->json($response,404);
        }else{
            $response = [
                'success' => true,
                'data'=>$all_vendors->first()
            ];
        return response()->json($response);
        }
    }

    public function addVendor(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            "vendor_name"=>'required',
            "location_id"=>'required|numeric|exists:locations,id',
            'agreement_details.*' => 'required|mimes:png,pdf|max:20000',
            "address"=>'required',
            "gst_details"=>'required',
            "bank_details"=>'required',
            "lane_name"=>'required',
            "contact_person_mobile.*"=>'required|numeric',
            "contact_person_mail.*"=>'required'
        ],[  'agreement_details.*.required' => 'Please upload an image or pdf file',
        'agreement_details.*.mimes' => 'Only pdf and png are allowed',
        'agreement_details.*.max' => 'Sorry! Maximum allowed size for an image is 20MB',
        "contact_person_mobile.*required"=>'Mobile is required',
        "contact_person_mail.*required"=>'mail is required']);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => 'Validation Error',
                'error_code' => true,
                'error_message' => $validator->errors(),
            ];
            return response()->json($response, 200);
        }

        $vendor = new Vendor();
        $vendor->vendor_name = $request->input('vendor_name');
        $vendor->location_id = $request->input('location_id');
        $vendor->address = $request->input('address');
        $vendor->gst_details = $request->input('gst_details');
        $vendor->bank_details = $request->input('bank_details');
        $vendor->lane_name = $request->input('lane_name');
        
        if($vendor->save()){
            if($request->hasFile('agreement_details')){
                for($i =0 ;$i<count($request->file('agreement_details'));$i++){
                    $agreement_details = new AgreementDetail();
                    $file = $request->file('agreement_details')[$i];
                    $filename = time() . '.' . $request->file('agreement_details')[$i]->extension();
                    $filePath = public_path() . '/images/files/';
                    $file->move($filePath, $filename);           
                    $agreement_details->file = $filename;
                    $agreement_details->vendor_id = $vendor->id;
                    $agreement_details->save();
                }
            }
            for($i =0 ;$i<count($request->input('contact_person_mobile'));$i++){
                $contact_person = new ContactPersonDetail();
                $contact_person->mail = $request->input('contact_person_mail')[$i];
                $contact_person->mobile = $request->input('contact_person_mobile')[$i];
                $contact_person-> vendor_id=$vendor->id; 
                $contact_person->save(); 
            }
        }
            $response = [
                'success' => true,
                'msg'=>$vendor->first()
            ];
            return response()->json($response,201);
        
    }

    public function addLocation(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            "name"=>'required',
          ] );
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => 'Validation Error',
                'error_code' => true,
                'error_message' => $validator->errors(),
            ];
            return response()->json($response, 200);
        }
        $location_exists = Location::where('name',strtolower($request->input('name')))->count();
        if($location_exists > 0){
            $response = [
                'success' => false,
                'msg'=>'Location Already exists'
            ];
            return response()->json($response,200);
        }
        $location = new Location();
        $location->name = strtolower($request->input('name'));
        $location->save();
        $response = [
            'success' => true,
            'msg'=>$location->first()
        ];
        return response()->json($response,201);
        
    }
}
