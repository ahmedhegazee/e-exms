package com.ahmed.e_exam;

import android.annotation.SuppressLint;
import android.content.Intent;
import android.os.Bundle;
import android.view.MenuItem;

import androidx.annotation.NonNull;
import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.drawerlayout.widget.DrawerLayout;

import com.google.android.material.bottomnavigation.BottomNavigationView;
import com.google.android.material.navigation.NavigationView;

public class Profile extends AppCompatActivity implements NavigationView.OnNavigationItemSelectedListener {
    //initialize variables
    BottomNavigationView bottomNavigationView;
    DrawerLayout drawerLayout;
    Toolbar toolbar;
    NavigationView navigationView;
    ActionBarDrawerToggle toggle;

    @SuppressLint("RestrictedApi")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_profile);

        drawerLayout = findViewById(R.id.drawer);
        toolbar = findViewById(R.id.toolbar);
        navigationView = findViewById(R.id.navigationView);
        setSupportActionBar();
        getSupportActionBar().setDefaultDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowTitleEnabled(false);
        toggle = new ActionBarDrawerToggle(this,drawerLayout,toolbar,R.string.drawerOpen,R.string.drawerClose);
        drawerLayout.addDrawerListener(toggle);
        toggle.syncState();
        navigationView.setNavigationItemSelectedListener(this);

        //Assign variables
        bottomNavigationView =findViewById(R.id.bottom_nav);

        //set default selected layout
        bottomNavigationView.setSelectedItemId(R.id.q_bank);

        //Perform Itemselectedlistener
        bottomNavigationView.setOnNavigationItemReselectedListener(new BottomNavigationView.OnNavigationItemReselectedListener() {
            @Override
            public void onNavigationItemReselected(@NonNull MenuItem item) {
                switch (item.getItemId())
                {
                    case R.id.q_bank:

                        break;

                    case R.id.result_analysis:
                        startActivity(new Intent(getApplicationContext(),Question_bank.class));
                        overridePendingTransition(0,0);
                        break;

                    case R.id.training_exam:
                        startActivity(new Intent(getApplicationContext(),Training_exam.class));
                        overridePendingTransition(0,0);
                        break;

                    case R.id.profile_data:
                        startActivity(new Intent(getApplicationContext(),Profile_data.class));
                        overridePendingTransition(0,0);
                       break;
                }
            }
        });

    }

    private void setSupportActionBar()
    {

    }

    public boolean onNavigationItemSelected(@NonNull MenuItem menuItem) {
        switch (menuItem.getItemId()){
            case R.id.profile:
                startActivity(new Intent(getApplicationContext(),Profile.class));
                break;
            case R.id.helpandfeedback:
                startActivity(new Intent(getApplicationContext(),Helpandfeedback.class));
                break;
            case R.id.finalexam:
                startActivity(new Intent(getApplicationContext(),Finalexam.class));
                break;
            default:
                break;
        }
        return false;
    }
}