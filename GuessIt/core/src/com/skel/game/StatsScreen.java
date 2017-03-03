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
import com.skel.util.*;

import java.nio.charset.Charset;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashMap;
import java.util.StringTokenizer;

/**
 * Created by juanm on 01/03/2016.
 */
public class StatsScreen implements Screen, Net.HttpResponseListener {

    Utils utilidades = new Utils();

    private UserInfo userInfo;
    private MainGame g;
    private Stage stage;
    private Skin skin;

    private Group grupo;

    private Strings_I18N locale;

    Net.HttpRequest httpsolicitud;
    String httpMethod = Net.HttpMethods.POST;

    private Table scroll_table;
    private HintSpeech toSpeech;

    Label userNameLabel, defPlayedLabel, numDefPlayedLabel, successesPlayedLabel, numSuccessesPlayedLabel, avgRatingPlayedLabel, numAvgRatingPlayedLabel, catMostPlayedLabel, stringCatMostPlayedLabel, categoriesLabel, reportedDefLabel;

    public void createStageActors(){
        userNameLabel = new Label(userInfo.getName() + " " + userInfo.getLastname(), skin.get("small", Label.LabelStyle.class));
        userNameLabel.setWrap(true);
        userNameLabel.setAlignment(Align.center);

        defPlayedLabel = new Label(locale.defPlayed(), skin.get("stats", Label.LabelStyle.class));
        defPlayedLabel.setWrap(true);
        defPlayedLabel.setAlignment(Align.center);

        numDefPlayedLabel = new Label("", skin.get("small", Label.LabelStyle.class));
        numDefPlayedLabel.setWrap(true);
        numDefPlayedLabel.setAlignment(Align.center);

        successesPlayedLabel = new Label(locale.sucPlayed(), skin.get("stats", Label.LabelStyle.class));
        successesPlayedLabel.setWrap(true);
        successesPlayedLabel.setAlignment(Align.center);

        numSuccessesPlayedLabel = new Label("", skin.get("small", Label.LabelStyle.class));
        numSuccessesPlayedLabel.setWrap(true);
        numSuccessesPlayedLabel.setAlignment(Align.center);

        avgRatingPlayedLabel = new Label(locale.avgRated(), skin.get("stats", Label.LabelStyle.class));
        avgRatingPlayedLabel.setWrap(true);
        avgRatingPlayedLabel.setAlignment(Align.center);

        numAvgRatingPlayedLabel = new Label("", skin.get("small", Label.LabelStyle.class));
        numAvgRatingPlayedLabel.setWrap(true);
        numAvgRatingPlayedLabel.setAlignment(Align.center);

        catMostPlayedLabel = new Label(locale.mostCategory(), skin.get("stats", Label.LabelStyle.class));
        catMostPlayedLabel.setAlignment(Align.center);
        catMostPlayedLabel.setWrap(true);

        stringCatMostPlayedLabel = new Label("", skin.get("small", Label.LabelStyle.class));
        stringCatMostPlayedLabel.setWrap(true);
        stringCatMostPlayedLabel.setAlignment(Align.center);

        reportedDefLabel = new Label(locale.reportedDef(), skin.get("stats", Label.LabelStyle.class));
        reportedDefLabel.setAlignment(Align.center);
        reportedDefLabel.setWrap(true);

        categoriesLabel = new Label("Kategorie", skin.get("stats", Label.LabelStyle.class));
        categoriesLabel.setAlignment(Align.center);
        categoriesLabel.setWrap(true);

        scroll_table = new Table();

        scroll_table.add(userNameLabel).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.1f).colspan(3);
        scroll_table.row();

        scroll_table.add(defPlayedLabel).width(Gdx.graphics.getWidth()*0.4f).height(Gdx.graphics.getHeight()*0.15f);
        scroll_table.add().width(Gdx.graphics.getWidth()*0.05f).height(Gdx.graphics.getHeight()*0.15f);
        scroll_table.add(numDefPlayedLabel).width(Gdx.graphics.getWidth()*0.35f).height(Gdx.graphics.getHeight()*0.15f);
        scroll_table.row();

        scroll_table.add().height(Gdx.graphics.getHeight()*0.01f).colspan(3);
        scroll_table.row();

        scroll_table.add(successesPlayedLabel).width(Gdx.graphics.getWidth()*0.4f).height(Gdx.graphics.getHeight()*0.15f);
        scroll_table.add().width(Gdx.graphics.getWidth()*0.05f).height(Gdx.graphics.getHeight()*0.15f);
        scroll_table.add(numSuccessesPlayedLabel).width(Gdx.graphics.getWidth()*0.35f).height(Gdx.graphics.getHeight()*0.15f);
        scroll_table.row();

        scroll_table.add().height(Gdx.graphics.getHeight()*0.01f).colspan(3);
        scroll_table.row();
        /*
        scroll_table.add(avgRatingPlayedLabel).width(Gdx.graphics.getWidth()*0.4f).height(Gdx.graphics.getHeight()*0.15f);
        scroll_table.add().width(Gdx.graphics.getWidth()*0.05f).height(Gdx.graphics.getHeight()*0.15f);
        scroll_table.add(numAvgRatingPlayedLabel).width(Gdx.graphics.getWidth()*0.35f).height(Gdx.graphics.getHeight()*0.15f);
        scroll_table.row();
        */
        scroll_table.add(catMostPlayedLabel).width(Gdx.graphics.getWidth()*0.4f).height(Gdx.graphics.getHeight()*0.2f);
        scroll_table.add().width(Gdx.graphics.getWidth()*0.05f).height(Gdx.graphics.getHeight()*0.2f);
        scroll_table.add(stringCatMostPlayedLabel).width(Gdx.graphics.getWidth()*0.35f).height(Gdx.graphics.getHeight()*0.2f);
        scroll_table.row();

        scroll_table.add().height(Gdx.graphics.getHeight()*0.01f).colspan(3);
        scroll_table.row();

        generateReportedDefs();
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

        createStageActors();
    }

    public StatsScreen(MainGame g, UserInfo UInfo, Group group, Skin skin, HintSpeech toSpeech){
        this.g = g;
        this.skin = skin;
        userInfo = UInfo;
        this.grupo = group;
        this.toSpeech = toSpeech;

        locale = new Strings_I18N(grupo.getLanguageName());

        create();
    }

    public void generateReportedDefs(){
        HashMap<String, String> parameters = new HashMap<String, String>();
        parameters.put("id_usuario",String.valueOf(userInfo.getId()));
        parameters.put("id_aula", String.valueOf(grupo.getId()));
        String url = utilidades.getUrl()+"getReportedDef.php?";
        httpsolicitud = new Net.HttpRequest(httpMethod);
        httpsolicitud.setUrl(url);
        httpsolicitud.setContent(HttpParametersUtils.convertHttpParameters(parameters));
        Gdx.net.sendHttpRequest(httpsolicitud,StatsScreen.this);
    }
    @Override
    public void handleHttpResponse(Net.HttpResponse httpResponse) {
        final String ResponseBefore = httpResponse.getResultAsString();
        final String Response = new String(ResponseBefore.getBytes(), Charset.forName("UTF-8"));
        Gdx.app.log("stats", Response);
        Gdx.app.postRunnable(new Runnable() {
            @Override
            public void run() {
                if(!Response.isEmpty()){
                    // Stuff
                    StringTokenizer stroker = new StringTokenizer(Response, ";");
                    if(stroker.hasMoreElements()) {
                        numDefPlayedLabel.setText(stroker.nextToken());
                        numSuccessesPlayedLabel.setText(stroker.nextToken());
                        numAvgRatingPlayedLabel.setText(stroker.nextToken());
                        stringCatMostPlayedLabel.setText(stroker.nextToken());
                        boolean catLabel = false;
                        boolean repLabel = false;
                        boolean inCat = false;
                        while(stroker.hasMoreElements()){
                            String isReported = stroker.nextToken();
                            if(isReported.equals("#")) {
                               inCat = !inCat;
                            }
                            if (inCat) {
                                if (!catLabel) {
                                    scroll_table.add(categoriesLabel).width(Gdx.graphics.getWidth() * 0.8f).height(Gdx.graphics.getHeight() * 0.1f).colspan(3);
                                    scroll_table.row();
                                    scroll_table.add().height(Gdx.graphics.getHeight()*0.01f).colspan(3);
                                    scroll_table.row();
                                    scroll_table.add(new Label("Name", skin.get("stats", Label.LabelStyle.class))).width(Gdx.graphics.getWidth() * 0.4f).height(Gdx.graphics.getHeight() * 0.1f).getActor().setAlignment(Align.center);
                                    scroll_table.add().width(Gdx.graphics.getWidth()*0.05f).height(Gdx.graphics.getHeight()*0.1f);
                                    scroll_table.add(new Label("Definition", skin.get("stats", Label.LabelStyle.class))).width(Gdx.graphics.getWidth() * 0.3f).height(Gdx.graphics.getHeight() * 0.1f).getActor().setAlignment(Align.center);
                                    //Label tmpLabel = new Label("Number of definitions", skin.get("stats", Label.LabelStyle.class));
                                    //tmpLabel.setAlignment(Align.center);
                                    //tmpLabel.setWrap(true);
                                    //scroll_table.add(tmpLabel).width(Gdx.graphics.getWidth() * 0.3f).height(Gdx.graphics.getHeight() * 0.1f);
                                    scroll_table.row();
                                    scroll_table.add().height(Gdx.graphics.getHeight()*0.01f).colspan(3);
                                    scroll_table.row();
                                    catLabel = true;
                                } else {
                                    Label tmpLabel = new Label(isReported, skin.get("stats", Label.LabelStyle.class));
                                    tmpLabel.setWrap(true);
                                    scroll_table.add(tmpLabel).width(Gdx.graphics.getWidth() * 0.4f).height(Gdx.graphics.getHeight() * 0.3f).getActor().setAlignment(Align.center);
                                    tmpLabel = new Label(stroker.nextToken(), skin.get("small", Label.LabelStyle.class));
                                    tmpLabel.setWrap(true);
                                    scroll_table.add().width(Gdx.graphics.getWidth() * 0.05f).height(Gdx.graphics.getHeight() * 0.3f);
                                    scroll_table.add(tmpLabel).width(Gdx.graphics.getWidth() * 0.1f).height(Gdx.graphics.getHeight() * 0.3f);
                                    //tmpLabel = new Label("/" + stroker.nextToken(), skin.get("small", Label.LabelStyle.class));
                                    //tmpLabel.setWrap(true);
                                    //scroll_table.add(tmpLabel).width(Gdx.graphics.getWidth() * 0.1f).height(Gdx.graphics.getHeight() * 0.1f);
                                    scroll_table.row();
                                    scroll_table.add().height(Gdx.graphics.getHeight()*0.01f).colspan(3);
                                    scroll_table.row();
                                }
                            } else {
                                if(!repLabel){
                                    scroll_table.add(reportedDefLabel).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.1f).colspan(3);
                                    scroll_table.row();
                                    scroll_table.add().height(Gdx.graphics.getHeight()*0.01f).colspan(3);
                                    scroll_table.row();
                                    repLabel = true;
                                }
                                else {
                                    Label tmpLabel = new Label(isReported, skin.get("stats", Label.LabelStyle.class));
                                    tmpLabel.setWrap(true);
                                    scroll_table.add(tmpLabel).width(Gdx.graphics.getWidth() * 0.4f).height(Gdx.graphics.getHeight() * 0.1f).getActor().setAlignment(Align.center);
                                    tmpLabel = new Label(stroker.nextToken(), skin.get("small", Label.LabelStyle.class));
                                    tmpLabel.setWrap(true);
                                    scroll_table.add().width(Gdx.graphics.getWidth() * 0.05f).height(Gdx.graphics.getHeight() * 0.1f);
                                    scroll_table.add(tmpLabel).width(Gdx.graphics.getWidth() * 0.3f).height(Gdx.graphics.getHeight() * 0.1f);
                                    tmpLabel = new Label(stroker.nextToken(), skin.get("small", Label.LabelStyle.class));
                                    tmpLabel.setWrap(true);
                                    scroll_table.add(tmpLabel).width(Gdx.graphics.getWidth() * 0.1f).height(Gdx.graphics.getHeight() * 0.1f);
                                    scroll_table.row();
                                    scroll_table.add().height(Gdx.graphics.getHeight()*0.01f).colspan(3);
                                    scroll_table.row();
                                }
                            }
                        }
                    }
                }

                ImageTextButton backButton = new ImageTextButton(locale.back(), skin.get("back", ImageTextButton.ImageTextButtonStyle.class));
                backButton.addListener(new ClickListener() {
                    public void clicked(InputEvent event, float x, float y) {
                       g.setScreen(new StatsMenuScreen(g, userInfo, grupo, skin, toSpeech));
                       dispose();
                   }
                });
                scroll_table.add(backButton).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.1f).colspan(3);

                ScrollPane scroller = new ScrollPane(scroll_table);

                final Table table = new Table();
                table.setFillParent(true);
                table.add(scroller).expand().fill();

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
