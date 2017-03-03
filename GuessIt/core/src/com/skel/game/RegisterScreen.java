package com.skel.game;

import com.badlogic.gdx.*;
import com.badlogic.gdx.graphics.GL20;
import com.badlogic.gdx.net.HttpParametersUtils;
import com.badlogic.gdx.scenes.scene2d.InputEvent;
import com.badlogic.gdx.scenes.scene2d.InputListener;
import com.badlogic.gdx.scenes.scene2d.Stage;
import com.badlogic.gdx.scenes.scene2d.ui.*;
import com.badlogic.gdx.scenes.scene2d.utils.ClickListener;
import com.badlogic.gdx.utils.Align;
import com.badlogic.gdx.utils.TimeUtils;
import com.badlogic.gdx.utils.viewport.FillViewport;
import com.badlogic.gdx.utils.viewport.StretchViewport;
import com.skel.util.HintSpeech;
import com.skel.util.Utils;

import java.nio.charset.Charset;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashMap;

/**
 * Created by juanm on 28/01/2016.
 */
public class RegisterScreen implements Screen, Net.HttpResponseListener {
    Utils utilidades = new Utils();
    Stage stage;
    Skin skin;

    private Preferences defSaved;

    //Items de la pantalla
    Label labelLogin,labelPass,labelName,labelLastname,labelEmail;
    TextField userLogin, userPass, userName, userLastname, userEmail;
    TextButton LoginButton;
    ImageTextButton backButton;
    //Container
    Table scroll_contenedor;

    MainGame g;

    Window successRegisterWindow;

    //Utiles net
    SimpleDateFormat dFormat = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
    Net.HttpRequest httpsolicitud;
    String httpMethod = Net.HttpMethods.POST;

    private HintSpeech toSpeech;

    public RegisterScreen(MainGame g, Skin skin, HintSpeech toSpeech){
        this.g = g;
        this.skin = skin;
        defSaved = Gdx.app.getPreferences("UserState");
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
        Gdx.input.setInputProcessor(stage);
        Gdx.input.setCatchBackKey(true);

        createStageActors();
    }

    public void createStageActors(){

        successRegisterWindow = new Window("Success", skin.get("default", Window.WindowStyle.class));
        successRegisterWindow.setMovable(false);
        successRegisterWindow.setFillParent(true);
        successRegisterWindow.padTop(Gdx.graphics.getHeight()*0.05f);
        successRegisterWindow.getTitleLabel().setAlignment(Align.center);
        successRegisterWindow.getTitleLabel().setWrap(true);
        successRegisterWindow.setSize(Gdx.graphics.getWidth(),Gdx.graphics.getHeight());
        successRegisterWindow.setVisible(false);

        Label sucessRegister = new Label("Successfully registered", skin.get("default", Label.LabelStyle.class));
        sucessRegister.setAlignment(Align.center);
        sucessRegister.setWrap(true);

        successRegisterWindow.add(sucessRegister).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.3f);
        successRegisterWindow.row();

        TextButton registerOk = new TextButton("Ok", skin.get("default", TextButton.TextButtonStyle.class));
        registerOk.addListener(new ClickListener() {
            public void clicked(InputEvent event, float x, float y) {
                g.setScreen(new MainScreen(g, toSpeech));
                Gdx.input.setOnscreenKeyboardVisible(false);
                dispose();
            }
        });

        successRegisterWindow.add(registerOk).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.1f);
        successRegisterWindow.row();
        successRegisterWindow.pack();

        //Creacion de los elementos de la pantalla
        labelLogin = new Label("Username",skin.get("small", Label.LabelStyle.class));
        userLogin = new TextField("", skin.get("default",TextField.TextFieldStyle.class));
        labelPass = new Label("Password",skin.get("small", Label.LabelStyle.class));
        userPass = new TextField("", skin.get("default",TextField.TextFieldStyle.class));
        labelName = new Label("Name", skin.get("small", Label.LabelStyle.class));
        labelLastname = new Label("Last name", skin.get("small", Label.LabelStyle.class));
        labelEmail = new Label("Email", skin.get("small", Label.LabelStyle.class));
        userName = new TextField("", skin.get("default",TextField.TextFieldStyle.class));
        userLastname = new TextField("", skin.get("default",TextField.TextFieldStyle.class));
        userEmail = new TextField("", skin.get("default",TextField.TextFieldStyle.class));

        LoginButton = new TextButton("Register",skin);
        backButton = new ImageTextButton("Back",skin.get("back", ImageTextButton.ImageTextButtonStyle.class));

        //Activar caracteristicas de los actores
        //Labels

        labelLogin.setAlignment(Align.center);

        labelPass.setAlignment(Align.center);

        labelEmail.setAlignment(Align.center);

        labelLastname.setAlignment(Align.center);

        labelName.setAlignment(Align.center);

        //Text Fields
        userLogin.setAlignment(Align.center);

        userLogin.addListener(new InputListener(){
            public boolean keyTyped (InputEvent event, char character) {
                super.keyTyped(event,character);
                defSaved.putString("userLogin",userLogin.getText());
                defSaved.flush();
                return true;
            }
        });

        userPass.setPasswordMode(true);
        userPass.setAlignment(Align.center);
        userPass.setPasswordCharacter('*');

        userPass.addListener(new InputListener(){
            public boolean keyTyped (InputEvent event, char character) {
                super.keyTyped(event,character);
                defSaved.putString("userPass",userPass.getText());
                defSaved.flush();
                return true;
            }
        });

        userName.setAlignment(Align.center);

        userLastname.setAlignment(Align.center);

        userEmail.setAlignment(Align.center);

        //Funciones callback
        LoginButton.addListener(new ClickListener() {
            public void clicked(InputEvent event, float x, float y) {
                        HashMap<String, String> parameters = new HashMap<String, String>();
                        parameters.put("nombre", userName.getText());//new String(userName.getText().getBytes(), Charset.forName("UTF-8")));
                        parameters.put("apellidos", userLastname.getText());//new String(userLastname.getText().getBytes(), Charset.forName("UTF-8")));
                        parameters.put("email", userEmail.getText());//new String(userEmail.getText().getBytes(), Charset.forName("UTF-8")));
                        parameters.put("usuario", userLogin.getText());//new String(userLogin.getText().getBytes(), Charset.forName("UTF-8")));
                        parameters.put("password", userPass.getText());//new String(userPass.getText().getBytes(), Charset.forName("UTF-8")));
                        parameters.put("alta",dFormat.format(new Date(TimeUtils.millis())));
                        String url = utilidades.getUrl()+"register.php?";
                        //solicitud_variables = "&nombre=suscribete&puntaje=222";
                        httpsolicitud = new Net.HttpRequest(httpMethod);
                        httpsolicitud.setUrl(url);
                        httpsolicitud.setContent(HttpParametersUtils.convertHttpParameters(parameters));
                        Gdx.net.sendHttpRequest(httpsolicitud, RegisterScreen.this);
                    }
                }
        );

        backButton.addListener(new ClickListener() {
            public void clicked(InputEvent event, float x, float y) {
                g.setScreen(new MainScreen(g, toSpeech));
                Gdx.input.setOnscreenKeyboardVisible(false);
                dispose();
            }
        });

        //Creamos la tabla contenedora de nuestra interfaz de registro
        //Se pueden "encadenar" funciones para el control del tamaño, la posicion nos la da la propia tabla

        scroll_contenedor = new Table();

        scroll_contenedor.add(labelName).width(Gdx.graphics.getWidth()*0.35f).height(Gdx.graphics.getHeight()*0.075f);
        scroll_contenedor.add().width(Gdx.graphics.getWidth()*0.1f).height(Gdx.graphics.getHeight()*0.075f);
        scroll_contenedor.add(labelLastname).width(Gdx.graphics.getWidth()*0.35f).height(Gdx.graphics.getHeight()*0.075f);

        scroll_contenedor.row();

        scroll_contenedor.add(userName).width(Gdx.graphics.getWidth()*0.35f).height(Gdx.graphics.getHeight()*0.075f);
        scroll_contenedor.add().width(Gdx.graphics.getWidth()*0.1f).height(Gdx.graphics.getHeight()*0.075f);
        scroll_contenedor.add(userLastname).width(Gdx.graphics.getWidth()*0.35f).height(Gdx.graphics.getHeight()*0.075f);

        scroll_contenedor.row();

        scroll_contenedor.add(labelEmail).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.075f).colspan(3);

        scroll_contenedor.row();

        scroll_contenedor.add(userEmail).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.075f).colspan(3);

        scroll_contenedor.row();

        scroll_contenedor.add(labelLogin).width(Gdx.graphics.getWidth()*0.35f).height(Gdx.graphics.getHeight()*0.075f);
        scroll_contenedor.add().width(Gdx.graphics.getWidth()*0.1f).height(Gdx.graphics.getHeight()*0.075f);
        scroll_contenedor.add(labelPass).width(Gdx.graphics.getWidth()*0.35f).height(Gdx.graphics.getHeight()*0.075f);

        scroll_contenedor.row(); // Creamos una nueva fila

        scroll_contenedor.add(userLogin).width(Gdx.graphics.getWidth()*0.35f).height(Gdx.graphics.getHeight()*0.075f);
        scroll_contenedor.add().width(Gdx.graphics.getWidth()*0.1f).height(Gdx.graphics.getHeight()*0.075f);
        scroll_contenedor.add(userPass).width(Gdx.graphics.getWidth()*0.35f).height(Gdx.graphics.getHeight()*0.075f);

        scroll_contenedor.row();

        scroll_contenedor.add(LoginButton).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.075f).colspan(3);

        scroll_contenedor.row();

        scroll_contenedor.add(backButton).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.075f).colspan(3);

        scroll_contenedor.row();

        //ScrollPane scroller = new ScrollPane(scroll_contenedor);

        // Esta tabla es contenedora del scroll pane, importante para visualizar los contenidos y centrar la interfaz

        final Table table = new Table();
        table.setFillParent(true);
        table.add(scroll_contenedor).fill().expandX();
        table.top();
        //Anadimos la tabla al stage
        stage.addActor(table);
        stage.addActor(successRegisterWindow);
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
        Gdx.app.postRunnable(new Runnable() {
            @Override
            public void run() {
                if(Response.isEmpty()){
                    Gdx.app.log("conexion","fallida");
                }else{
                    Gdx.app.log("conexion",Response);
                    //Gdx.app.log("time", dFormat.format(new Date(TimeUtils.millis()).toString()));
                    Gdx.input.setOnscreenKeyboardVisible(false);
                    successRegisterWindow.setVisible(true);
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