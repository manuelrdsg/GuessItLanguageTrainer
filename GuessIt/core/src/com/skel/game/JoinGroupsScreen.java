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
import com.badlogic.gdx.utils.viewport.FillViewport;
import com.badlogic.gdx.utils.viewport.StretchViewport;
import com.skel.util.Group;
import com.skel.util.HintSpeech;
import com.skel.util.UserInfo;
import com.skel.util.Utils;

import java.nio.charset.Charset;
import java.util.HashMap;
import java.util.StringTokenizer;

/**
 * Created by juanm on 24/02/2016.
 */
public class JoinGroupsScreen implements Screen, Net.HttpResponseListener {

    Utils utilidades = new Utils();

    private UserInfo userInfo;
    private MainGame g;
    private Stage stage;
    private Skin skin;

    Net.HttpRequest httpsolicitud;
    String httpMethod = Net.HttpMethods.POST;

    private Table ScrollTable = new Table();

    private boolean groupIsSelected = false;

    private Group selected_group;
    private HintSpeech toSpeech;

    public JoinGroupsScreen(MainGame g, UserInfo UInfo, Skin skin, HintSpeech toSpeech){
        this.g = g;
        this.skin = skin;
        userInfo = UInfo;
        this.toSpeech = toSpeech;
        create();
    }

    public void createStageActors(){

    }

    public void create(){
        stage = new Stage(new FillViewport(Gdx.graphics.getWidth(),Gdx.graphics.getHeight())){
            @Override
            public boolean keyDown(int keyCode) {
                if (keyCode == Input.Keys.BACK) {
                    g.setScreen(new UserGroupsScreen(g, userInfo, skin, toSpeech));
                    Gdx.input.setOnscreenKeyboardVisible(false);
                    dispose();
                }
                return super.keyDown(keyCode);
            }
        };
        Gdx.input.setInputProcessor(stage);
        Gdx.input.setCatchBackKey(true);
        //Llamar a connection y que devolviese el resultado de los grupos a los que el alumno ha sido validado
        createStageActors();

        HashMap<String, String> parameters = new HashMap<String, String>();
        parameters.put("id_usuario",String.valueOf(userInfo.getId()));
        String url = utilidades.getUrl()+"getGroups.php?";
        //solicitud_variables = "&nombre=suscribete&puntaje=222";
        httpsolicitud = new Net.HttpRequest(httpMethod);
        httpsolicitud.setUrl(url);
        httpsolicitud.setContent(HttpParametersUtils.convertHttpParameters(parameters));
        Gdx.net.sendHttpRequest(httpsolicitud,JoinGroupsScreen.this);
    }

    public void sendGroupInvite(Group grupo){
        HashMap<String, String> parameters = new HashMap<String, String>();
        parameters.put("id_usuario",String.valueOf(userInfo.getId()));
        parameters.put("id_aula",String.valueOf(grupo.getId()));
        String url = utilidades.getUrl()+"inviteGroup.php?";
        httpsolicitud = new Net.HttpRequest(httpMethod);
        httpsolicitud.setUrl(url);
        httpsolicitud.setContent(HttpParametersUtils.convertHttpParameters(parameters));
        Gdx.net.sendHttpRequest(httpsolicitud,JoinGroupsScreen.this);
    }

    @Override
    public void handleHttpResponse(Net.HttpResponse httpResponse) {
        final String ResponseBefore = httpResponse.getResultAsString();
        final String Response = new String(ResponseBefore.getBytes(), Charset.forName("UTF-8"));
        Gdx.app.log("respuesta", Response);
        if(groupIsSelected){
            Gdx.app.postRunnable(new Runnable() {
                @Override
                public void run() {
                    groupIsSelected = false;
                }
            });
        }else {
            Gdx.app.postRunnable(new Runnable() {
                @Override
                public void run() {
                    if (!Response.isEmpty()) {
                        StringTokenizer stroker = new StringTokenizer(Response, ";");
                        while (stroker.hasMoreElements()) {
                            final TextButton tmpTButton = new TextButton("", skin.get("group", TextButton.TextButtonStyle.class));
                            final int iGroupId = Integer.parseInt(stroker.nextElement().toString());
                            final String groupName = stroker.nextElement().toString();
                            final String teacherName = stroker.nextElement().toString();
                            final int iGroupLang = Integer.parseInt(stroker.nextElement().toString());
                            tmpTButton.setText(groupName + " - " + teacherName);
                            tmpTButton.getLabel().setAlignment(Align.center);
                            tmpTButton.getLabel().setWrap(true);
                            tmpTButton.getLabelCell().padLeft(10f).padTop(10f).padRight(10f).padBottom(10f);
                            // Añadir el funcionamiento de cada boton
                            tmpTButton.addListener(new ClickListener() {
                                public void clicked(InputEvent event, float x, float y) {
                                    Group grupo = new Group(iGroupId, groupName, teacherName, iGroupLang, "");
                                    selected_group = grupo;
                                    groupIsSelected = true;
                                    tmpTButton.setVisible(false);
                                    sendGroupInvite(grupo);
                                }
                            });
                            ScrollTable.add(tmpTButton).width(Gdx.graphics.getWidth() * 0.8f).height(Gdx.graphics.getHeight() * 0.15f);
                            ScrollTable.row();
                        }
                        Gdx.app.log("conexion", "tabla creada");

                        Gdx.app.log("conexion", "tabla grupos creada");
                    } else {
                        Gdx.app.log("conexion", "ningun resultado");
                    }
                    // Boton cancelar para volver a la ventana anterior
                    ImageTextButton CancelButton = new ImageTextButton("Back", skin.get("back", ImageTextButton.ImageTextButtonStyle.class));
                    CancelButton.addListener(new ClickListener() {
                        public void clicked(InputEvent event, float x, float y) {
                            g.setScreen(new UserGroupsScreen(g, userInfo, skin, toSpeech));
                            dispose();
                        }
                    });
                    ScrollTable.add(CancelButton).width(Gdx.graphics.getWidth() * 0.8f).height(Gdx.graphics.getHeight() * 0.1f);
                    ScrollTable.row();

                    ScrollPane scroller = new ScrollPane(ScrollTable);
                    Gdx.app.log("conexion", "scroll creado");

                    final Table table = new Table();
                    table.setFillParent(true);
                    table.add(scroller).fill().expand();

                    //Anadimos la tabla al stage
                    stage.addActor(table);
                }
            });
        }
    }

    @Override
    public void failed(Throwable t) {

    }

    @Override
    public void cancelled() {

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
}
