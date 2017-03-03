package com.skel.game;

import com.badlogic.gdx.*;
import com.badlogic.gdx.graphics.GL20;
import com.badlogic.gdx.net.HttpParametersUtils;
import com.badlogic.gdx.scenes.scene2d.*;
import com.badlogic.gdx.scenes.scene2d.actions.Actions;
import com.badlogic.gdx.scenes.scene2d.ui.*;
import com.badlogic.gdx.scenes.scene2d.utils.ChangeListener;
import com.badlogic.gdx.scenes.scene2d.utils.ClickListener;
import com.badlogic.gdx.utils.Align;
import com.badlogic.gdx.utils.viewport.FillViewport;
import com.skel.util.HintSpeech;
import com.skel.util.UserInfo;
import com.skel.util.Utils;

import java.nio.charset.Charset;
import java.util.HashMap;
import java.util.StringTokenizer;

/**
 * Created by juanm on 27/01/2016.
 */
public class LoginScreen implements Screen, Net.HttpResponseListener {

    Utils utilidades = new Utils();

    Stage stage;
    Skin skin;

    //Items de la pantalla
    Label labelLogin,labelPass, errorLabel;
    TextField userLogin, userPass;
    TextButton LoginButton, okButton;
    ImageTextButton backButton;
    CheckBox remember;

    private Preferences prefs;

    MainGame g;

    UserInfo UInfo = new UserInfo();

    Net.HttpRequest httpsolicitud;
    String httpMethod = Net.HttpMethods.POST;

    private Window errorWindow;
    private HintSpeech toSpeech;

    public LoginScreen(MainGame g, Skin skin, HintSpeech toSpeech){
        this.g = g;
        this.skin = skin;
        this.toSpeech = toSpeech;
        create();
    }

    public void create(){
        stage = new Stage(new FillViewport(Gdx.graphics.getWidth(),Gdx.graphics.getHeight())){
            @Override
            public boolean keyDown(int keyCode) {
                if (keyCode == Input.Keys.BACK) {
                    g.setScreen(new MainScreen(g, toSpeech));
                    Gdx.input.setOnscreenKeyboardVisible(false);
                    dispose();
                }
                return super.keyDown(keyCode);
            }
        };
        prefs = Gdx.app.getPreferences("UserState");
        Gdx.input.setInputProcessor(stage);
        Gdx.input.setCatchBackKey(true);
        createStageActors();
    }

    public void createStageActors(){

        Table table = new Table();

        errorWindow = new Window("Login error!", skin.get("default", Window.WindowStyle.class));
        errorWindow.setMovable(false);
        errorWindow.setFillParent(true);
        errorWindow.padTop(Gdx.graphics.getHeight()*0.05f);
        errorWindow.getTitleLabel().setAlignment(Align.center);
        errorWindow.getTitleLabel().setWrap(true);
        errorWindow.setSize(Gdx.graphics.getWidth(),Gdx.graphics.getHeight());
        errorWindow.setVisible(false);

        //Creacion de los elementos de la pantalla
        labelLogin = new Label("Email",skin.get("default", Label.LabelStyle.class));
        userLogin = new TextField("", skin.get("default",TextField.TextFieldStyle.class));
        labelPass = new Label("Password",skin.get("default", Label.LabelStyle.class));
        userPass = new TextField("", skin.get("default",TextField.TextFieldStyle.class));
        LoginButton = new TextButton("Login",skin);
        backButton = new ImageTextButton("Back",skin.get("back", ImageTextButton.ImageTextButtonStyle.class));
        remember = new CheckBox(" Remember me!", skin.get("default", CheckBox.CheckBoxStyle.class));

        //Activar caracteristicas de los actores
        //Labels

        labelLogin.setAlignment(Align.center);

        labelPass.setAlignment(Align.center);

        //Text Fields
        userLogin.setAlignment(Align.center);

        userLogin.addListener(new InputListener(){
            public boolean keyTyped (InputEvent event, char character) {
                super.keyTyped(event,character);
                prefs.putString("userLogin",userLogin.getText());
                prefs.flush();
                return true;
            }
        });
        //userLogin.setMessageText("User");

        userPass.setPasswordMode(true);
        //userPass.setMessageText("Password");
        userPass.setAlignment(Align.center);
        userPass.setPasswordCharacter('*');

        userPass.addListener(new InputListener(){
            public boolean keyTyped (InputEvent event, char character) {
                super.keyTyped(event,character);
                prefs.putString("userPass",userPass.getText());
                prefs.flush();
                return true;
            }
        });

        userLogin.setText(prefs.getString("userLogin",""));
        userPass.setText(prefs.getString("userPass",""));

        /*remember.setChecked(false);
        if(prefs.getBoolean("remember",false)){
            remember.setChecked(true);

        }*/
        //Funciones callback
        LoginButton.addListener(new ClickListener() {
            public void clicked(InputEvent event, float x, float y) {
                        prefs.putInteger("14",50);
                        prefs.flush();
                        // Conexion http
                        HashMap<String, String> parameters = new HashMap<String, String>();
                        parameters.put("usuario",new String(userLogin.getText().getBytes(), Charset.forName("UTF-8")));
                        parameters.put("password",new String(userPass.getText().getBytes(), Charset.forName("UTF-8")));
                        String url = utilidades.getUrl()+"login.php?";
                        //solicitud_variables = "&nombre=suscribete&puntaje=222";
                        httpsolicitud = new Net.HttpRequest(httpMethod);
                        httpsolicitud.setUrl(url);
                        httpsolicitud.setContent(HttpParametersUtils.convertHttpParameters(parameters));
                        Gdx.net.sendHttpRequest(httpsolicitud,LoginScreen.this);
                        // Fin conexion http
                    }
                }
        );

        backButton.addListener(new ClickListener() {
            public void clicked(InputEvent event, float x, float y) {
                g.setScreen(new MainScreen(g, toSpeech));
                dispose();
            }
        });

        remember.addListener(new ChangeListener() {
            @Override
            public void changed(ChangeEvent event, Actor actor) {
                if(remember.isChecked()){
                    prefs.putBoolean("remember",true);
                    prefs.putString("userLogin", userLogin.getText());
                    prefs.putString("userPass", userPass.getText());
                    prefs.flush();
                }else{
                    prefs.putBoolean("remember",false);
                    prefs.putString("userLogin", "");
                    prefs.putString("userPass", "");
                    prefs.flush();
                }
            }
        });

        //Anadimos actores al stage
        table.add(labelLogin).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.1f);
        table.row();
        table.add(userLogin).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.1f);
        table.row();
        table.add(labelPass).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.1f);
        table.row();
        table.add(userPass).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.1f);
        table.row();
        table.add().width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.1f);
        table.row();
        table.add(LoginButton).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.1f);
        table.row();
        table.add(backButton).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.1f);
        table.row();
        table.pack();

        final Table tabla = new Table();
        tabla.setFillParent(true);
        tabla.add(table).expand().top();
        stage.addActor(tabla);

        okButton = new TextButton("Ok!", skin.get("default", TextButton.TextButtonStyle.class));
        errorLabel = new Label("", skin.get("default", Label.LabelStyle.class));
        errorLabel.setWrap(true);

        okButton.addListener(new ClickListener(){
            public void clicked(InputEvent event, float x, float y) {
                errorWindow.setVisible(false);
            }
        });

        errorWindow.add(errorLabel).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.2f);
        errorWindow.row();
        errorWindow.add(okButton).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.1f);
        errorWindow.row();
        errorWindow.pack();

        stage.addActor(errorWindow);
        //stage.addActor(remember);
    }

    @Override
    public void show() {

    }

    @Override
    public void render(float delta) {
        Gdx.gl.glClear(GL20.GL_COLOR_BUFFER_BIT);
        Gdx.gl.glClearColor(0.95f, 0.95f, 0.95f, 1);
        stage.act(delta);
        stage.draw();
    }

    @Override
    public void resize(int width, int height) {
        stage.getViewport().update(width, height, false);
    }

    @Override
    public void pause() {

    }

    @Override
    public void resume() {

    }

    @Override
    public void hide() {

    }

    @Override
    public void dispose() {
        stage.dispose();
        //skin.dispose();
    }

    @Override
    public void handleHttpResponse(Net.HttpResponse httpResponse) {
        final String ResponseBefore = httpResponse.getResultAsString();
        final String Response = new String(ResponseBefore.getBytes(), Charset.forName("UTF-8"));
        Gdx.app.log("conexion", Response);
        Gdx.app.postRunnable(new Runnable() {
            @Override
            public void run() {
                if(Response.isEmpty()){
                    Gdx.app.log("conexion","fallida");
                    prefs.putInteger("14",50);
                    prefs.flush();
                    g.setScreen(new MainScreen(g, toSpeech));
                    Gdx.input.setOnscreenKeyboardVisible(false);
                    dispose();
                }else {
                    StringTokenizer stroker = new StringTokenizer(Response,"|");
                    while(stroker.hasMoreTokens()) {
                        String responseType = stroker.nextToken();
                        Gdx.app.log("conexion error type", responseType);
                        if(responseType.equals("1")) {
                            UInfo.setInfo(stroker.nextToken());
                            //Gdx.app.log("conexion",UInfo.getName());
                            Gdx.app.log("conexion", "resuelta");
                            g.setScreen(new UserGroupsScreen(g, UInfo, skin, toSpeech));
                            Gdx.input.setOnscreenKeyboardVisible(false);
                            dispose();
                        }else{
                            Gdx.input.setOnscreenKeyboardVisible(false);
                            String responseFailure = stroker.nextToken();
                            errorLabel.setText(responseFailure);
                            errorWindow.setVisible(true);
                        }
                    }
                }
            }
        });
    }

    @Override
    public void failed(Throwable t) {

    }

    @Override
    public void cancelled() {

    }
}
