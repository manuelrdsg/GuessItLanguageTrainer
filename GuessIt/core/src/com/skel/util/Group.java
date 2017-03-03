package com.skel.util;

/**
 * Created by juanm on 24/02/2016.
 */
public class Group {

    private int id, id_idioma;
    private String nombre, profesor, language;

    public Group(){

    }

    public Group(int id, String nombre, String profesor, int id_idioma, String language){
        this.id = id;
        this.nombre = nombre;
        this.profesor = profesor;
        this.id_idioma = id_idioma;
        this.language = language;
    }

    public int getId(){
        return id;
    }

    public String getName(){
        return nombre;
    }

    public String getTeacher(){
        return profesor;
    }

    public int getLanguage(){
        return id_idioma;
    }

    public String getLanguageName(){
        return language;
    }
}
