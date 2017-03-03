package com.skel.game;

import com.badlogic.gdx.*;
import com.badlogic.gdx.graphics.GL20;
import com.badlogic.gdx.net.HttpParametersUtils;
import com.badlogic.gdx.scenes.scene2d.*;
import com.badlogic.gdx.scenes.scene2d.ui.*;
import com.badlogic.gdx.scenes.scene2d.utils.ChangeListener;
import com.badlogic.gdx.scenes.scene2d.utils.ClickListener;
import com.badlogic.gdx.scenes.scene2d.utils.FocusListener;
import com.badlogic.gdx.utils.Align;
import com.badlogic.gdx.utils.TimeUtils;
import com.badlogic.gdx.utils.viewport.FillViewport;
import com.badlogic.gdx.utils.viewport.StretchViewport;
import com.skel.util.*;
import com.skel.util.Group;

import java.nio.charset.Charset;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.StringTokenizer;

/**
 * Created by juanm on 03/03/2016.
 */
public class NewDefScreen implements Screen, Net.HttpResponseListener {

    Utils utilidades = new Utils();

    private UserInfo userInfo;
    private MainGame g;
    private Stage stage;
    private Skin skin;

    private Group grupo;

    private Strings_I18N locale;
    private HintSpeech toSpeech;

    Net.HttpRequest httpsolicitud;
    String httpMethod = Net.HttpMethods.POST;

    private Table scrollTable;

    ImageTextButton backButton, sendButton;
    TextArea sentence, hint;
    Label word, article, wordLabel, articleLabel, lvLabel, catLabel, level, category;

    ButtonGroup<TextButton> categoriesGroup = new ButtonGroup<TextButton>();

    private ArrayList<Integer> categories = new ArrayList<Integer>();
    private int actualLevel = 0;
    private boolean sendingDefinition;
    private int actualCategory = 0;

    SimpleDateFormat dFormat = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");

    private Preferences prefs;

    private String wordString, categoryString, articleString;

    public void generateWord(){
        HashMap<String, String> parameters = new HashMap<String, String>();
        parameters.put("id_aula",String.valueOf(grupo.getId()));
        String url = utilidades.getUrl()+"getDefWord.php?";
        httpsolicitud = new Net.HttpRequest(httpMethod);
        httpsolicitud.setUrl(url);
        httpsolicitud.setContent(HttpParametersUtils.convertHttpParameters(parameters));
        Gdx.net.sendHttpRequest(httpsolicitud,NewDefScreen.this);
    }

    public void sendDefinition(){
        HashMap<String, String> parameters = new HashMap<String, String>();
        parameters.put("nivel", String.valueOf(actualLevel)); // CAMBIAR
        parameters.put("palabra", new String(wordString.getBytes(), Charset.forName("UTF-8")));
        parameters.put("articulo", new String(articleString.getBytes(), Charset.forName("UTF-8")));
        parameters.put("frase", new String(sentence.getText().getBytes(), Charset.forName("UTF-8")));
        parameters.put("pista", new String(hint.getText().getBytes(), Charset.forName("UTF-8")));
        parameters.put("id_categoria", String.valueOf(actualCategory)); // CAMBIAR
        parameters.put("id_usuario", String.valueOf(userInfo.getId()));
        parameters.put("id_aula",String.valueOf(grupo.getId()));
        parameters.put("fecha", dFormat.format(new Date(TimeUtils.millis())));
        String url = utilidades.getUrl()+"sendDefinition.php?";
        httpsolicitud = new Net.HttpRequest(httpMethod);
        httpsolicitud.setUrl(url);
        httpsolicitud.setContent(HttpParametersUtils.convertHttpParameters(parameters));
        Gdx.net.sendHttpRequest(httpsolicitud,NewDefScreen.this);
    }

    public void createStageActors(){
        scrollTable = new Table();

        word = new Label("", skin.get("newdefword", Label.LabelStyle.class));
        wordLabel = new Label("[RED]Word:", skin.get("newdefword", Label.LabelStyle.class));
        article = new Label("", skin.get("newdefcat", Label.LabelStyle.class));
        articleLabel = new Label("[BLACK]Article:", skin.get("newdefword", Label.LabelStyle.class));
        sentence = new TextArea("", skin.get("default", TextField.TextFieldStyle.class));
        sentence.setMessageText("Enter the sentence");
        sentence.setMaxLength(80);
        sentence.setPrefRows(3);
        /*sentence.addListener(new FocusListener() {
            @Override
            public boolean handle(Event event) {
                float oldX, oldY, oldZ;
                oldX = stage.getCamera().position.x;
                oldY = stage.getCamera().position.y;
                oldZ = stage.getCamera().position.z;
                boolean isFocused = super.handle(event);
                if(isFocused){
                    stage.getCamera().position.set(oldX, Gdx.graphics.getHeight()/2, oldZ);
                    stage.getCamera().update();
                }
                return isFocused;
            }
        });*/
        hint = new TextArea("", skin.get("default", TextField.TextFieldStyle.class));
        hint.setMessageText("Enter the hint");
        hint.setMaxLength(80);
        hint.setPrefRows(3);
        /*hint.addListener(new FocusListener() {
            @Override
            public boolean handle(Event event) {
                float oldX, oldY, oldZ;
                oldX = stage.getCamera().position.x;
                oldY = stage.getCamera().position.y;
                oldZ = stage.getCamera().position.z;
                boolean isFocused = super.handle(event);
                if(isFocused){
                    stage.getCamera().position.set(oldX, Gdx.graphics.getHeight()/2, oldZ);
                    stage.getCamera().update();
                }
                return isFocused;
            }
        });*/

        lvLabel = new Label("[BLACK]Level:", skin.get("newdefcat", Label.LabelStyle.class));
        catLabel = new Label("[BLACK]Category:", skin.get("newdefcat", Label.LabelStyle.class));
        level = new Label("", skin.get("newdefword", Label.LabelStyle.class));
        category = new Label("", skin.get("newdefword", Label.LabelStyle.class));

        //scrollTable.debug();


        scrollTable.add(catLabel).width(Gdx.graphics.getWidth() * 0.2f).height(Gdx.graphics.getHeight() * 0.1f);
        scrollTable.add().width(Gdx.graphics.getWidth() * 0.05f).height(Gdx.graphics.getHeight() * 0.1f);
        scrollTable.add(category).width(Gdx.graphics.getWidth() * 0.5f).height(Gdx.graphics.getHeight() * 0.1f).colspan(5);
        scrollTable.row();
        scrollTable.add(articleLabel).width(Gdx.graphics.getWidth() * 0.2f).height(Gdx.graphics.getHeight() * 0.1f);
        scrollTable.add().width(Gdx.graphics.getWidth() * 0.05f).height(Gdx.graphics.getHeight() * 0.1f);
        scrollTable.add(article).width(Gdx.graphics.getWidth() * 0.2f).height(Gdx.graphics.getHeight() * 0.1f);
        scrollTable.add().width(Gdx.graphics.getWidth() * 0.05f).height(Gdx.graphics.getHeight() * 0.1f);
        scrollTable.add(lvLabel).width(Gdx.graphics.getWidth() * 0.15f).height(Gdx.graphics.getHeight() * 0.1f);
        scrollTable.add().width(Gdx.graphics.getWidth() * 0.05f).height(Gdx.graphics.getHeight() * 0.1f);
        scrollTable.add(level).width(Gdx.graphics.getWidth() * 0.1f).height(Gdx.graphics.getHeight() * 0.1f);
        scrollTable.row();
        scrollTable.add(wordLabel).width(Gdx.graphics.getWidth() * 0.2f).height(Gdx.graphics.getHeight() * 0.1f);
        scrollTable.add().width(Gdx.graphics.getWidth() * 0.05f).height(Gdx.graphics.getHeight() * 0.1f);
        scrollTable.add(word).width(Gdx.graphics.getWidth() * 0.5f).height(Gdx.graphics.getHeight() * 0.1f).colspan(5);
        scrollTable.row();
        scrollTable.add(sentence).width(Gdx.graphics.getWidth() * 0.8f).height(Gdx.graphics.getHeight() * 0.2f).colspan(7);
        scrollTable.row();
        scrollTable.add(hint).width(Gdx.graphics.getWidth() * 0.8f).height(Gdx.graphics.getHeight() * 0.2f).colspan(7);
        scrollTable.row();
        if(prefs.getBoolean("NDexist")){
            actualLevel = prefs.getInteger("NDlvl");
            word.setText("[RED]"+prefs.getString("NDword"));
            article.setText("[BLACK]"+prefs.getString("NDarticle"));
            actualCategory = prefs.getInteger("NDcat");
            category.setText("[BLACK]"+prefs.getString("NDcatN"));
            level.setText("[BLACK]"+String.valueOf(actualLevel));
        }else{
            generateWord();
        }
        sendButton = new ImageTextButton(locale.send(), skin.get("send", ImageTextButton.ImageTextButtonStyle.class));
        sendButton.addListener(new ClickListener() {
            public void clicked(InputEvent event, float x, float y) {
                sendingDefinition = true;
                sendDefinition();
                g.setScreen(new MenuGameScreen(g,userInfo,grupo, skin, toSpeech));
                Gdx.input.setOnscreenKeyboardVisible(false);
                dispose();
            }
        });

        scrollTable.add(sendButton).width(Gdx.graphics.getWidth() * 0.8f).height(Gdx.graphics.getHeight() * 0.1f).colspan(7);
        scrollTable.row();

        backButton = new ImageTextButton(locale.back(), skin.get("back", ImageTextButton.ImageTextButtonStyle.class));
        backButton.addListener(new ClickListener() {
            public void clicked(InputEvent event, float x, float y) {
                g.setScreen(new MenuGameScreen(g, userInfo, grupo, skin, toSpeech));
                Gdx.input.setOnscreenKeyboardVisible(false);
                dispose();
            }
        });

        scrollTable.add(backButton).width(Gdx.graphics.getWidth() * 0.8f).height(Gdx.graphics.getHeight() * 0.1f).colspan(7);

        ScrollPane scroll = new ScrollPane(scrollTable);
        final Table table = new Table();
        table.setFillParent(true);
        table.add(scroll).expand().top();
        stage.addActor(table);
    }

    public void create(){
        stage = new Stage(new FillViewport(Gdx.graphics.getWidth(),Gdx.graphics.getHeight())){
            @Override
            public boolean keyDown(int keyCode) {
                if (keyCode == Input.Keys.BACK) {
                    g.setScreen(new MenuGameScreen(g, userInfo, grupo, skin, toSpeech));
                    Gdx.input.setOnscreenKeyboardVisible(false);
                    dispose();
                }
                return super.keyDown(keyCode);
            }
        };
        Gdx.input.setInputProcessor(stage);
        Gdx.input.setCatchBackKey(true);

        prefs = Gdx.app.getPreferences("UserState");

        createStageActors();
    }

    public NewDefScreen(MainGame g, UserInfo UInfo, Group grupo, Skin skin, HintSpeech toSpeech){
        this.g = g;
        this.skin = skin;
        userInfo = UInfo;
        this.grupo = grupo;
        locale = new Strings_I18N(this.grupo.getLanguageName());
        sendingDefinition = false;
        this.toSpeech = toSpeech;
        create();
    }

    @Override
    public void handleHttpResponse(Net.HttpResponse httpResponse) {
        final String ResponseBefore = httpResponse.getResultAsString();
        final String Response = new String(ResponseBefore.getBytes(), Charset.forName("UTF-8"));
        Gdx.app.log("nueva def", Response);
        if(sendingDefinition){
            userInfo.addedNewDef(String.valueOf(grupo.getId()));
            sendingDefinition = false;
            prefs.putBoolean("NDexist", false);
            prefs.flush();
        }
        else {
            Gdx.app.postRunnable(new Runnable() {
                @Override
                public void run() {
                    StringTokenizer stroke = new StringTokenizer(Response, ";");
                    if(stroke.hasMoreTokens()) {
                        actualLevel = Integer.parseInt(stroke.nextToken());
                        level.setText("[BLACK]"+String.valueOf(actualLevel));
                        wordString = stroke.nextToken();
                        word.setText("[RED]"+wordString);
                        articleString = stroke.nextToken();
                        article.setText("[BLACK]"+ articleString);
                        actualCategory = Integer.parseInt(stroke.nextToken());
                        categoryString = stroke.nextToken();
                        category.setText("[BLACK]"+ categoryString);
                        prefs.putBoolean("NDexist", true);
                        prefs.putInteger("NDlvl", actualLevel);
                        prefs.putString("NDword", wordString);
                        prefs.putString("NDarticle", articleString);
                        prefs.putInteger("NDcat", actualCategory);
                        prefs.putString("NDcatN", categoryString);
                        prefs.flush();
                    }
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
