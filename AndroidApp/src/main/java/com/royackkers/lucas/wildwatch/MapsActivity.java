package com.royackkers.lucas.wildwatch;

import android.content.Intent;
import android.support.design.widget.FloatingActionButton;
import android.support.v4.app.FragmentActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Toast;

import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

public class MapsActivity extends FragmentActivity implements OnMapReadyCallback,AsyncResponse {

    private GoogleMap mMap;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_maps);
        // Obtain the SupportMapFragment and get notified when the map is ready to be used.
        SupportMapFragment mapFragment = (SupportMapFragment) getSupportFragmentManager()
                .findFragmentById(R.id.map);
        mapFragment.getMapAsync(this);
    }


    /**
     * Manipulates the map once available.
     * This callback is triggered when the map is ready to be used.
     * This is where we can add markers or lines, add listeners or move the camera. In this case,
     * we just add a marker near Sydney, Australia.
     * If Google Play services is not installed on the device, the user will be prompted to install
     * it inside the SupportMapFragment. This method will only be triggered once the user has
     * installed Google Play services and returned to the app.
     */
    @Override
    public void onMapReady(GoogleMap googleMap) {
        mMap = googleMap;

        // Add a marker in Sydney and move the camera
        LatLng caen = new LatLng(49.181054, -0.353016);
        mMap.moveCamera(CameraUpdateFactory.newLatLngZoom(caen,8));


        try {
            getMarkers("https://21400116.users.info.unicaen.fr/WebServiceWildWatch/web_service.php");
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    public void getMarkers(String link) throws IOException {
        WebService task = (WebService) new WebService();
        task.delegate = this;
        task.execute(link);
    }

    @Override
    public void processFinish(String output) {
        Float lat = null;
        Float lng = null;
        String typ = null;
        String dat = null;
        String Id = null;

        String replace1 = output.replace("[","");
        String replace2 = replace1.replace("]","");
        List<String> finalList = new ArrayList<String>(Arrays.asList(replace2.split("\\},")));
        for(String str : finalList) {
            String animalItemsVir = str.replace("{","");
            String[] animalItems = animalItemsVir.split(",");

            for(String keyValue : animalItems){
                if(keyValue.toLowerCase().contains("Latitude".toLowerCase())){
                    String init = keyValue.split(":")[1].replace('"',' ');
                    lat = Float.parseFloat(init);
                }
                else if(keyValue.toLowerCase().contains("Longitude".toLowerCase())){
                    String init = keyValue.split(":")[1].replace('"',' ');
                    lng = Float.parseFloat(init);
                }
                else if(keyValue.toLowerCase().contains("typ".toLowerCase())){
                    typ = keyValue.split(":")[1].replace('"',' ');
                }
                else if(keyValue.toLowerCase().contains("dat".toLowerCase())){
                    dat = keyValue.split(":")[1].replace('"',' ').split(" ")[1];
                }
                else if(keyValue.toLowerCase().contains("Id".toLowerCase())){
                    Id = keyValue.split(":")[1].replace('"',' ').split(" ")[1];
                }
            }

            if(lat != null && lng != null && typ != null){
                Log.d("New animal",typ+lat+","+lng);
                mMap.addMarker(new MarkerOptions()
                        .position(new LatLng(lat,lng))
                        .title(typ+"("+Id+")")
                        .icon(BitmapDescriptorFactory.fromResource(R.drawable.paw))
                        .snippet("Date : "+dat));
            }
        }
        FloatingActionButton fab = (FloatingActionButton) findViewById(R.id.floatingActionButton2);
        fab.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent myIntent = new Intent(getBaseContext(),PostActivity.class);
                startActivity(myIntent);
            }
        });
    }
}
