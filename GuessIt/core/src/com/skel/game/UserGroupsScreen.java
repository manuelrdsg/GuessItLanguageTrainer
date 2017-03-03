package com.skel.game;

import com.badlogic.gdx.*;
import com.badlogic.gdx.graphics.GL20;
import com.badlogic.gdx.graphics.Texture;
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
 * Created by juanm on 22/02/2016.
 */
public class UserGroupsScreen implements Screen, Net.HttpResponseListener {

    Utils utilidades = new Utils();

    private UserInfo userInfo;
    private MainGame g;
    private Stage stage;
    private Skin skin;

    //private Table upTable;
    private Table ScrollTable;

    Net.HttpRequest httpsolicitud;
    String httpMethod = Net.HttpMethods.POST;

    private Group selected_group;
    private HintSpeech toSpeech;

    public UserGroupsScreen(MainGame g, UserInfo UInfo, Skin skin, HintSpeech toSpeech) {
        this.g = g;
        this.skin = skin;
        userInfo = UInfo;
        this.toSpeech = toSpeech;
        create();
    }

    public void createStageActors(){
        //upTable = new Table();
        ScrollTable = new Table();

        // Search icon
        ImageButton searchIcon = new ImageButton(skin.get("search_icon", ImageButton.ImageButtonStyle.class));
        searchIcon.addListener(new ClickListener() {
            public void clicked(InputEvent event, float x, float y) {
                Gdx.app.log("botones","search pulsado");
            }
        });
        // Join icon
        ImageTextButton joinIcon = new ImageTextButton("   Join group", skin.get("join_icon", ImageTextButton.ImageTextButtonStyle.class));
        joinIcon.addListener(new ClickListener() {
            public void clicked(InputEvent event, float x, float y) {
                Gdx.app.log("botones","join pulsado");
                g.setScreen(new JoinGroupsScreen(g,userInfo, skin, toSpeech));
            }
        });

        TextField searchInput = new TextField("",skin.get("default",TextField.TextFieldStyle.class));
        Label joinLabel = new Label("Join group",skin.get("default", Label.LabelStyle.class));

        joinLabel.setAlignment(Align.center);

        // Sin mecanica de busqueda aun

        //ScrollTable.add(searchIcon).width(Gdx.graphics.getWidth()*0.1f).height(Gdx.graphics.getHeight()*0.1f);
        //ScrollTable.add(searchInput).width(Gdx.graphics.getWidth()*0.7f).height(Gdx.graphics.getHeight()*0.1f);
        //ScrollTable.row();

        ScrollTable.add(joinIcon).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.1f);
        //ScrollTable.add(joinLabel).width(Gdx.graphics.getWidth()*0.7f).height(Gdx.graphics.getHeight()*0.1f);
        ScrollTable.row();
        ScrollTable.setFillParent(true);
        ScrollTable.top();
        // Add tables to stage
        //stage.addActor(upTable);
    }

    public void create(){
        stage = new Stage(new FillViewport(Gdx.graphics.getWidth(),Gdx.graphics.getHeight())){
            @Override
            public boolean keyDown(int keyCode) {
                if (keyCode == Input.Keys.BACK) {
                    g.setScreen(new LoginScreen(g, skin, toSpeech));
                    Gdx.input.setOnscreenKeyboardVisible(false);
                    dispose();
                }
                return super.keyDown(keyCode);
            }
        };
        Gdx.input.setInputProcessor(stage);
        Gdx.input.setCatchBackKey(true);

        createStageActors();
        //Llamar a connection y que devolviese el resultado de los grupos a los que el alumno ha sido validado
        refreshGroups();
    }

    public void refreshGroups(){
        HashMap<String, String> parameters = new HashMap<String, String>();
        parameters.put("id_usuario",String.valueOf(userInfo.getId()));
        String url = utilidades.getUrl()+"getGroupsJoined.php?";
        httpsolicitud = new Net.HttpRequest(httpMethod);
        httpsolicitud.setUrl(url);
        httpsolicitud.setContent(HttpParametersUtils.convertHttpParameters(parameters));
        Gdx.net.sendHttpRequest(httpsolicitud,UserGroupsScreen.this);
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

    @Override
    public void handleHttpResponse(Net.HttpResponse httpResponse) {
        final String ResponseBefore = httpResponse.getResultAsString();
        final String Response = new String(ResponseBefore.getBytes(), Charset.forName("UTF-8"));
        Gdx.app.postRunnable(new Runnable() {
            @Override
            public void run() {
                if (!Response.isEmpty()) {
                    StringTokenizer stroker = new StringTokenizer(Response, ";");
                    while (stroker.hasMoreElements()) {
                        TextButton tmpTButton = new TextButton("", skin.get("group", TextButton.TextButtonStyle.class));
                        final int iGroupId = Integer.parseInt(stroker.nextElement().toString());
                        final String groupName = stroker.nextElement().toString();
                        final String teacherName = stroker.nextElement().toString();
                        final int iGroupLang = Integer.parseInt(stroker.nextElement().toString());
                        final String sGroupLang = stroker.nextToken();
                        final int cantidad = Integer.parseInt(stroker.nextToken());
                        tmpTButton.setText(groupName + " - " + teacherName + " (" + String.valueOf(cantidad) + ") ");
                        tmpTButton.getLabel().setAlignment(Align.center);
                        tmpTButton.getLabel().setWrap(true);
                        tmpTButton.getLabelCell().padLeft(10f).padTop(10f).padRight(10f).padBottom(10f);
                        // Añadir el funcionamiento de cada boton
                        tmpTButton.addListener(new ClickListener() {
                            public void clicked(InputEvent event, float x, float y) {
                                Group grupo = new Group(iGroupId, groupName, teacherName, iGroupLang, sGroupLang);
                                selected_group = grupo;
                                g.setScreen(new MenuGameScreen(g,userInfo,selected_group, skin, toSpeech));
                                dispose();
                                Gdx.app.log("probando grupo", grupo.getName());
                                // Llamada a nueva screen con la info del grupo
                            }
                        });
                        ScrollTable.add(tmpTButton).width(Gdx.graphics.getWidth() * 0.8f).height(Gdx.graphics.getHeight() * 0.15f);
                        ScrollTable.row();
                    }
                    /*Gdx.app.log("conexion", "tabla creada");
                    ScrollPane scroller = new ScrollPane(ScrollTable);
                    Gdx.app.log("conexion", "scroll creado");
                    final Table table = new Table();
                    table.setFillParent(true);
                    table.add(scroller).fill().expand();

                    //Anadimos la tabla al stage
                    stage.addActor(table);*/
                    Gdx.app.log("conexion", "tabla grupos creada");
                } else {
                    Gdx.app.log("conexion", "ningun resultado");
                }

                ImageTextButton backButton = new ImageTextButton("Back", skin.get("back", ImageTextButton.ImageTextButtonStyle.class));
                backButton.addListener(new ClickListener() {
                    public void clicked(InputEvent event, float x, float y) {
                        g.setScreen(new LoginScreen(g, skin, toSpeech));
                        dispose();
                    }
                });
                ScrollTable.add(backButton).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.1f).colspan(2);
                ScrollTable.row();
                TextButton refreshButton = new TextButton("Refresh", skin.get("default", TextButton.TextButtonStyle.class));
                refreshButton.addListener(new ClickListener() {
                    public void clicked(InputEvent event, float x, float y) {
                        g.setScreen(new UserGroupsScreen(g,userInfo, skin, toSpeech));
                        dispose();
                    }
                });
                ScrollTable.add(refreshButton).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.1f).colspan(2);
                ScrollTable.row();
                ScrollTable.pack();
                Gdx.app.log("conexion", "tabla creada");
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

    @Override
    public void failed(Throwable t) {

    }

    @Override
    public void cancelled() {

    }
}
