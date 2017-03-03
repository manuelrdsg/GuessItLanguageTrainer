package com.skel.util;

import com.badlogic.gdx.Gdx;
import com.badlogic.gdx.Preferences;

import java.util.StringTokenizer;

/**
 * Created by juanm on 22/02/2016.
 */
public class UserInfo {

    private String nombre,apellidos,email,usuario;

    private int testType,userId;

    private Preferences prefs;

    public UserInfo(){
        prefs = Gdx.app.getPreferences("UserState");
    }

    public UserInfo(String Info){
        StringTokenizer stroker = new StringTokenizer(Info,";");

        while(stroker.hasMoreElements()){
            userId = Integer.parseInt(stroker.nextElement().toString());
            nombre = stroker.nextElement().toString();
            apellidos = stroker.nextElement().toString();
            email = stroker.nextElement().toString();
            usuario = stroker.nextElement().toString();
            testType = Integer.parseInt(stroker.nextElement().toString());
        }

        prefs = Gdx.app.getPreferences("UserState");
    }

    public void setInfo(String Info){
        StringTokenizer stroker = new StringTokenizer(Info,";");

        while(stroker.hasMoreElements()){
            userId = Integer.parseInt(stroker.nextElement().toString());
            nombre = stroker.nextElement().toString();
            apellidos = stroker.nextElement().toString();
            email = stroker.nextElement().toString();
            usuario = stroker.nextElement().toString();
            testType = Integer.parseInt(stroker.nextElement().toString());
        }
    }

    public int getId(){
        return userId;
    }

    public String getName(){
        return nombre;
    }

    public String getLastname(){
        return apellidos;
    }

    public String getEmail(){
        return email;
    }

    public String getUser(){
        return usuario;
    }

    public int getType(){
        return testType;
    }

    public void addDefPlayed(String group_id){
        prefs.putInteger(group_id, prefs.getInteger(group_id, 0) + 1);
        prefs.flush();
    }

    public void addedNewDef(String group_id){
        prefs.putInteger(group_id, prefs.getInteger(group_id) - 50);
        prefs.flush();
    }

    public boolean canAddDefinition(String group_id){
        if(prefs.getInteger(group_id, 0) >= 50){
            //prefs.putInteger("defplayed", 0);
            //prefs.flush();
            return true;
        }else{
            return false;
        }
    }
}
