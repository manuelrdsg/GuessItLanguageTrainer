package com.skel.net;

/**
 * Created by juanm on 27/01/2016.
 */
import com.badlogic.gdx.Gdx;
import com.badlogic.gdx.Net;
import com.badlogic.gdx.Net.HttpRequest;
import com.badlogic.gdx.Net.HttpResponse;
import com.badlogic.gdx.Net.HttpResponseListener;
import com.badlogic.gdx.net.HttpParametersUtils;
import com.badlogic.gdx.utils.TimeUtils;
import com.skel.util.UserInfo;

import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashMap;

public class Connection implements HttpResponseListener{

    String url, mensaje="Registrando Puntaje.. espere";
    String httpMethod = Net.HttpMethods.POST;
    String solicitud_variables = null;
    HttpRequest httpsolicitud;

    SimpleDateFormat dFormat = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");

    boolean validatedUser = false;
    boolean createdUser = false;

    UserInfo UInfo = new UserInfo();

    public Connection(){}

    public void doTest(){
        url = "http://localhost/prueba/prueba.php?";
        solicitud_variables = "&nombre=suscribete&puntaje=222";
        httpsolicitud = new HttpRequest(httpMethod);
        httpsolicitud.setUrl(url);
        httpsolicitud.setContent(solicitud_variables);
        Gdx.net.sendHttpRequest(httpsolicitud, new HttpResponseListener() {
            @Override
            public void handleHttpResponse(HttpResponse httpResponse) {
                String A = httpResponse.getResultAsString();
                if(A.isEmpty()){

                }else{

                }
            }

            @Override
            public void failed(Throwable t) {

            }

            @Override
            public void cancelled() {

            }
        });
    }

    public void changeValidated(boolean value){
        validatedUser = value;
    }

    public boolean getValidated(){
        return validatedUser;
    }

    public void changeCreated(boolean value){
        createdUser = value;
    }

    public boolean getCreated(){
        return createdUser;
    }

    public void setUserInfo(final String str){
        Gdx.app.postRunnable(new Runnable() {
            @Override
            public void run() {
                UInfo.setInfo(str);
                validatedUser = true;
                System.out.println(UInfo.getName()+" "+validatedUser);
            }
        });
    }

    public UserInfo getUserInfo(){
        return UInfo;
    }


    public boolean createUser(String[] info){
        HashMap<String, String> parameters = new HashMap<String, String>();
        parameters.put("nombre", info[0]);
        parameters.put("apellidos", info[1]);
        parameters.put("email", info[2]);
        parameters.put("usuario",info[3]);
        parameters.put("password",info[4]);
        parameters.put("alta",dFormat.format(new Date(TimeUtils.millis())));
        url = "http://localhost/prueba/register.php?";
        //solicitud_variables = "&nombre=suscribete&puntaje=222";
        httpsolicitud = new HttpRequest(httpMethod);
        httpsolicitud.setUrl(url);
        httpsolicitud.setContent(HttpParametersUtils.convertHttpParameters(parameters));
        Gdx.net.sendHttpRequest(httpsolicitud, new HttpResponseListener() {
            @Override
            public void handleHttpResponse(HttpResponse httpResponse) {
                String A = httpResponse.getResultAsString();
                Gdx.app.log("conexion",A);
                Gdx.app.log("time", dFormat.format(new Date(TimeUtils.millis()).toString()));
            }

            @Override
            public void failed(Throwable t) {

            }

            @Override
            public void cancelled() {

            }
        });
        return true;
    }

    public void validateUser(String username, String password){

        HashMap<String, String> parameters = new HashMap<String, String>();
        parameters.put("usuario",username);
        parameters.put("password",password);
        url = "http://localhost/prueba/login.php?";
        //solicitud_variables = "&nombre=suscribete&puntaje=222";
        httpsolicitud = new HttpRequest(httpMethod);
        httpsolicitud.setUrl(url);
        httpsolicitud.setContent(HttpParametersUtils.convertHttpParameters(parameters));
        Gdx.net.sendHttpRequest(httpsolicitud, new HttpResponseListener() {
            @Override
            public void handleHttpResponse(HttpResponse httpResponse) {
                String Response = httpResponse.getResultAsString();
                if(!Response.isEmpty())
                    Gdx.app.log("conexion",Response);
                if(!Response.isEmpty()){
                    // PARA ROMPER EL THREAD HANDLE HAY QUE HACER UNA LLAMADA A OTRA FUNCION, LA FUNCION QUE SEA, DA IGUAL, PERO ROMPE EL HANDLE Y VUELVE A LA NORMALIDAD
                    //changeValidated(true);
                    setUserInfo(Response);
                    Gdx.app.log("login","logueado con exito");
                }else{
                    //changeValidated(false);
                    Gdx.app.log("login","fallo al loguear");
                }
            }

            @Override
            public void failed(Throwable t) {

            }

            @Override
            public void cancelled() {

            }
        });
    }

    @Override
    public void handleHttpResponse(final HttpResponse httpResponse) {

    }

    @Override
    public void failed(Throwable t) {

    }

    @Override
    public void cancelled() {

    }
}
