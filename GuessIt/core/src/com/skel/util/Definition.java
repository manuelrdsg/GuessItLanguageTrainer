package com.skel.util;

/**
 * Created by juanm on 25/02/2016.
 */
public class Definition {

    private int id, lv, id_categoria, id_aula;
    private String palabra, articulo, frase, pista;

    public Definition(){

    }

    public Definition(int id, int lv, String palabra, String articulo, String frase, String pista, int id_categoria, int id_aula){
        this.id = id;
        this.lv = lv;
        this.id_categoria = id_categoria;
        this.id_aula = id_aula;
        this.palabra = palabra;
        this.articulo = articulo;
        this.frase = frase;
        this.pista = pista;
    }

    public void setInfo(int id, int lv, String palabra, String articulo, String frase, String pista, int id_categoria, int id_aula){
        this.id = id;
        this.lv = lv;
        this.id_categoria = id_categoria;
        this.id_aula = id_aula;
        this.palabra = palabra;
        this.articulo = articulo;
        this.frase = frase;
        this.pista = pista;
    }

    public int getId(){return id;}
    public int getLv(){return lv;}
    public int getCategoria(){return id_categoria;}
    public int getGrupo(){return id_aula;}
    public String getPalabra(){return palabra;}
    public String getArticulo(){return articulo;}
    public String getFrase(){return frase;}
    public String getPista(){return pista;}
}
