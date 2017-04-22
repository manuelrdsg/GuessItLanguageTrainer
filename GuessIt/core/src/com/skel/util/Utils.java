package com.skel.util;

import com.badlogic.gdx.Application;
import com.badlogic.gdx.Gdx;
import com.badlogic.gdx.graphics.Color;
import com.badlogic.gdx.graphics.Texture;
import com.badlogic.gdx.graphics.g2d.BitmapFont;
import com.badlogic.gdx.graphics.g2d.TextureAtlas;
import com.badlogic.gdx.graphics.g2d.freetype.FreeTypeFontGenerator;
import com.badlogic.gdx.scenes.scene2d.ui.*;
import com.badlogic.gdx.scenes.scene2d.utils.TextureRegionDrawable;

/**
 * Created by juanm on 20/01/2016.
 */
public class Utils {

    public Utils(){

    }

    public BitmapFont CreateFont(int size, Color color){
        FreeTypeFontGenerator generator = new FreeTypeFontGenerator(Gdx.files.internal("fonts/arial.ttf"));
        FreeTypeFontGenerator.FreeTypeFontParameter parameter = new FreeTypeFontGenerator.FreeTypeFontParameter();
        parameter.size = size;
        parameter.color = color;
        parameter.minFilter = Texture.TextureFilter.Nearest;
        parameter.magFilter = Texture.TextureFilter.Linear;
        BitmapFont tmpFont = generator.generateFont(parameter);
        tmpFont.getData().markupEnabled = true;
        generator.dispose();
        return tmpFont;
    }

    public BitmapFont CreateResultFont(int size){
        FreeTypeFontGenerator generator = new FreeTypeFontGenerator(Gdx.files.internal("fonts/arial.ttf"));
        FreeTypeFontGenerator.FreeTypeFontParameter parameter = new FreeTypeFontGenerator.FreeTypeFontParameter();
        parameter.size = size;
        parameter.minFilter = Texture.TextureFilter.Nearest;
        parameter.magFilter = Texture.TextureFilter.Linear;
        BitmapFont tmpFont = generator.generateFont(parameter);
        tmpFont.getData().markupEnabled = true;
        generator.dispose();
        return tmpFont;
    }

    public Skin createBasicSkin(){
        TextureAtlas basic_atlas = new TextureAtlas(Gdx.files.internal("images_packed/basic.atlas"));
        Skin tmpSkin = new Skin();
        //Add font
        if(Gdx.app.getType() == Application.ApplicationType.Android) {
            tmpSkin.add("default", CreateFont((int) (20 * Gdx.graphics.getDensity()), Color.WHITE));
            tmpSkin.add("textfield", CreateFont((int) (30 * Gdx.graphics.getDensity()), Color.BLACK));
            tmpSkin.add("textfield_s", CreateFont((int)(20 * Gdx.graphics.getDensity()), Color.BLACK));
            tmpSkin.add("label", CreateFont((int) (30 * Gdx.graphics.getDensity()), Color.BLACK));
            tmpSkin.add("group", CreateFont((int) (20 * Gdx.graphics.getDensity()), Color.WHITE));
            tmpSkin.add("point", CreateFont((int) (80 * Gdx.graphics.getDensity()), Color.BLACK));
            tmpSkin.add("defLabel", CreateFont((int) (20 * Gdx.graphics.getDensity()), Color.WHITE));
            tmpSkin.add("defCat", CreateFont((int) (15 * Gdx.graphics.getDensity()), Color.WHITE));
        }else{
            if(Gdx.app.getType() == Application.ApplicationType.Desktop){
                tmpSkin.add("default", CreateFont(20 , Color.WHITE));
                tmpSkin.add("textfield", CreateFont(30 , Color.BLACK));
                tmpSkin.add("textfield_s", CreateFont(20 , Color.BLACK));
                tmpSkin.add("label", CreateFont(30 , Color.BLACK));
                tmpSkin.add("group", CreateFont(20 , Color.WHITE));
                tmpSkin.add("point", CreateFont(80 , Color.BLACK));
                tmpSkin.add("defLabel", CreateFont(20 , Color.WHITE));
                tmpSkin.add("defCat", CreateFont(15 , Color.WHITE));
            }
        }
        tmpSkin.addRegions(basic_atlas);
        //TextButton Style
        TextButton.TextButtonStyle tbStyle = new TextButton.TextButtonStyle();
        tbStyle.up = new TextureRegionDrawable(tmpSkin.getRegion("basic_button_idle"));
        tbStyle.down = new TextureRegionDrawable(tmpSkin.getRegion("basic_button_push"));
        tbStyle.checked = null;//new TextureRegionDrawable(tmpSkin.getRegion("basic_button_push"));
        tbStyle.over = new TextureRegionDrawable(tmpSkin.getRegion("basic_button_push"));
        tbStyle.font = tmpSkin.getFont("default");
        tmpSkin.add("default",tbStyle);
        // TextButton groups
        tbStyle = new TextButton.TextButtonStyle();
        tbStyle.up = new TextureRegionDrawable(tmpSkin.getRegion("basic_group_idle"));
        tbStyle.down = new TextureRegionDrawable(tmpSkin.getRegion("basic_group_push"));
        tbStyle.checked = new TextureRegionDrawable(tmpSkin.getRegion("basic_group_push"));
        tbStyle.over = new TextureRegionDrawable(tmpSkin.getRegion("basic_group_push"));
        tbStyle.font = tmpSkin.getFont("group");
        tbStyle.fontColor = Color.BLACK;
        tmpSkin.add("group",tbStyle);
        // Level
        tbStyle = new TextButton.TextButtonStyle();
        tbStyle.up = new TextureRegionDrawable(tmpSkin.getRegion("basic_button_idle"));
        tbStyle.down = new TextureRegionDrawable(tmpSkin.getRegion("basic_button_push"));
        tbStyle.checked = new TextureRegionDrawable(tmpSkin.getRegion("basic_button_push"));
        tbStyle.over = new TextureRegionDrawable(tmpSkin.getRegion("basic_button_push"));
        tbStyle.font = tmpSkin.getFont("group");
        tbStyle.fontColor = Color.WHITE;
        tmpSkin.add("level",tbStyle);
        // TextButton points
        tbStyle = new TextButton.TextButtonStyle();
        tbStyle.up = new TextureRegionDrawable(tmpSkin.getRegion("puntuacion"));
        tbStyle.down = new TextureRegionDrawable(tmpSkin.getRegion("puntuacion"));
        tbStyle.checked = null;
        tbStyle.over = null;
        tbStyle.font = tmpSkin.getFont("group");
        tmpSkin.add("point",tbStyle);
        // TextButton report
        tbStyle = new TextButton.TextButtonStyle();
        tbStyle.up = new TextureRegionDrawable(tmpSkin.getRegion("report"));
        tbStyle.down = new TextureRegionDrawable(tmpSkin.getRegion("report"));
        tbStyle.checked = null;
        tbStyle.over = null;
        tbStyle.font = tmpSkin.getFont("group");
        tmpSkin.add("report",tbStyle);
        //Label Style
        Label.LabelStyle lStyle = new Label.LabelStyle();
        lStyle.background = new TextureRegionDrawable(tmpSkin.getRegion("basic_label"));
        lStyle.background.setLeftWidth(5f);
        lStyle.background.setRightWidth(5f);
        lStyle.font = tmpSkin.getFont("label");
        //tmpSkin.getFont("label").getData().markupEnabled = true;
        tmpSkin.add("default",lStyle);

        lStyle = new Label.LabelStyle();
        lStyle.background = new TextureRegionDrawable(tmpSkin.getRegion("basic_stats_label"));
        lStyle.background.setLeftWidth(5f);
        lStyle.background.setRightWidth(5f);
        lStyle.font = tmpSkin.getFont("group");
        lStyle.fontColor = Color.BLACK;
        //tmpSkin.getFont("label").getData().markupEnabled = true;
        tmpSkin.add("stats",lStyle);
        // Puntuacion style
        lStyle = new Label.LabelStyle();
        lStyle.background = new TextureRegionDrawable(tmpSkin.getRegion("basic_label"));
        lStyle.background.setLeftWidth(5f);
        lStyle.background.setRightWidth(5f);
        lStyle.font = tmpSkin.getFont("point");
        tmpSkin.add("point", lStyle);
        // Small Label
        lStyle = new Label.LabelStyle();
        lStyle.background = new TextureRegionDrawable(tmpSkin.getRegion("basic_label"));
        lStyle.background.setLeftWidth(5f);
        lStyle.background.setRightWidth(5f);
        lStyle.font = tmpSkin.getFont("group");
        lStyle.fontColor = Color.BLACK;
        tmpSkin.add("small", lStyle);

        lStyle = new Label.LabelStyle();
        lStyle.background = new TextureRegionDrawable(tmpSkin.getRegion("basic_question_label"));
        lStyle.background.setLeftWidth(5f);
        lStyle.background.setRightWidth(5f);
        lStyle.font = tmpSkin.getFont("label");
        //tmpSkin.getFont("label").getData().markupEnabled = true;
        tmpSkin.add("question",lStyle);

        lStyle = new Label.LabelStyle();
        lStyle.background = new TextureRegionDrawable(tmpSkin.getRegion("logo"));
        lStyle.background.setLeftWidth(5f);
        lStyle.background.setRightWidth(5f);
        lStyle.font = tmpSkin.getFont("label");
        tmpSkin.add("logo",lStyle);

        lStyle = new Label.LabelStyle();
        lStyle.background = new TextureRegionDrawable(tmpSkin.getRegion("basic_label"));
        lStyle.background.setLeftWidth(5f);
        lStyle.background.setRightWidth(5f);
        if(Gdx.app.getType() == Application.ApplicationType.Android){
            lStyle.font = tmpSkin.getFont("defLabel");
        }else{
            lStyle.font = tmpSkin.getFont("default");
        }
        tmpSkin.add("newdefword", lStyle);

        lStyle = new Label.LabelStyle();
        lStyle.background = new TextureRegionDrawable(tmpSkin.getRegion("basic_label"));
        lStyle.background.setLeftWidth(5f);
        lStyle.background.setRightWidth(5f);
        if(Gdx.app.getType() == Application.ApplicationType.Android){
            lStyle.font = tmpSkin.getFont("defCat");
        }else{
            lStyle.font = tmpSkin.getFont("defCat");
        }
        tmpSkin.add("newdefcat", lStyle);
        //TextArea Style
        TextField.TextFieldStyle tfStyle = new TextField.TextFieldStyle();
        tfStyle.background = new TextureRegionDrawable(tmpSkin.getRegion("basic_text_area"));
        tfStyle.selection = new TextureRegionDrawable(tmpSkin.getRegion("selection"));
        tfStyle.font = tmpSkin.getFont("textfield_s");
        tfStyle.fontColor = Color.BLACK;
        tfStyle.cursor = new TextureRegionDrawable(tmpSkin.getRegion("cursor"));
        tfStyle.background.setLeftWidth(5f);
        tfStyle.background.setRightWidth(5f);
        tmpSkin.add("default",tfStyle);
        // ImageButton Style
        // Search Icon
        ImageButton.ImageButtonStyle ibStyle_Search = new ImageButton.ImageButtonStyle();
        ibStyle_Search.imageUp = new TextureRegionDrawable(tmpSkin.getRegion("search_icon"));
        tmpSkin.add("search_icon",ibStyle_Search);
        // Join Icon
        ImageButton.ImageButtonStyle ibStyle_Join = new ImageButton.ImageButtonStyle();
        ibStyle_Join.imageUp = new TextureRegionDrawable(tmpSkin.getRegion("join_icon"));
        tmpSkin.add("join_icon",ibStyle_Join);
        //Checkbox Style
        CheckBox.CheckBoxStyle cbStyle = new CheckBox.CheckBoxStyle();
        cbStyle.checkboxOff = new TextureRegionDrawable(tmpSkin.getRegion("uncheck"));
        cbStyle.checkboxOn = new TextureRegionDrawable(tmpSkin.getRegion("check"));
        cbStyle.font = tmpSkin.getFont("default");
        cbStyle.fontColor = Color.BLACK;
        tmpSkin.add("default",cbStyle);
        // Another Check Style
        cbStyle = new CheckBox.CheckBoxStyle();
        cbStyle.checkboxOff = new TextureRegionDrawable(tmpSkin.getRegion("uncheck"));
        cbStyle.checkboxOn = new TextureRegionDrawable(tmpSkin.getRegion("check"));
        cbStyle.font = tmpSkin.getFont("textfield");
        cbStyle.fontColor = Color.BLACK;
        tmpSkin.add("questions",cbStyle);
        //Window Style
        Window.WindowStyle wStyle = new Window.WindowStyle();
        wStyle.titleFont = tmpSkin.getFont("default");
        wStyle.titleFontColor = Color.BLACK;
        wStyle.background = new TextureRegionDrawable(tmpSkin.getRegion("basic_window_bg"));
        tmpSkin.add("default",wStyle);
        //
        ImageTextButton.ImageTextButtonStyle itStyle = new ImageTextButton.ImageTextButtonStyle();
        itStyle.up = new TextureRegionDrawable(tmpSkin.getRegion("report"));
        itStyle.down = new TextureRegionDrawable(tmpSkin.getRegion("report"));
        itStyle.checked = null;
        itStyle.over = null;
        itStyle.font = tmpSkin.getFont("label");
        itStyle.fontColor = Color.BLACK;
        tmpSkin.add("report",itStyle);
        //
        itStyle = new ImageTextButton.ImageTextButtonStyle();
        itStyle.up = new TextureRegionDrawable(tmpSkin.getRegion("join_icon"));
        itStyle.down = new TextureRegionDrawable(tmpSkin.getRegion("join_icon"));
        itStyle.checked = null;
        itStyle.over = null;
        itStyle.font = tmpSkin.getFont("default");
        itStyle.fontColor = Color.BLACK;
        tmpSkin.add("join_icon",itStyle);

        itStyle = new ImageTextButton.ImageTextButtonStyle();
        itStyle.up = new TextureRegionDrawable(tmpSkin.getRegion("basic_back_button"));
        itStyle.down = new TextureRegionDrawable(tmpSkin.getRegion("basic_back_button_p"));
        itStyle.checked = null;
        itStyle.over = null;
        itStyle.font = tmpSkin.getFont("default");
        itStyle.fontColor = Color.WHITE;
        tmpSkin.add("back",itStyle);

        itStyle = new ImageTextButton.ImageTextButtonStyle();
        itStyle.up = new TextureRegionDrawable(tmpSkin.getRegion("basic_send_button"));
        itStyle.down = new TextureRegionDrawable(tmpSkin.getRegion("basic_send_button"));
        itStyle.checked = null;
        itStyle.over = null;
        itStyle.font = tmpSkin.getFont("default");
        itStyle.fontColor = Color.WHITE;
        tmpSkin.add("send",itStyle);

        itStyle = new ImageTextButton.ImageTextButtonStyle();
        itStyle.up = new TextureRegionDrawable(tmpSkin.getRegion("basic_save_button"));
        itStyle.down = new TextureRegionDrawable(tmpSkin.getRegion("basic_save_button"));
        itStyle.checked = null;
        itStyle.over = null;
        itStyle.font = tmpSkin.getFont("default");
        itStyle.fontColor = Color.WHITE;
        tmpSkin.add("save",itStyle);
        //
        return tmpSkin;
    }

    public Skin createResultSkin(){
        TextureAtlas basic_atlas = new TextureAtlas(Gdx.files.internal("images_packed/basic.atlas"));
        Skin tmpSkin = new Skin();
        if(Gdx.app.getType() == Application.ApplicationType.Android) {
            tmpSkin.add("result", CreateResultFont((int) (20 * Gdx.graphics.getDensity())));
            tmpSkin.add("article", CreateResultFont((int) (30 * Gdx.graphics.getDensity())));
        }else{
            if(Gdx.app.getType() == Application.ApplicationType.Desktop){
                tmpSkin.add("result", CreateResultFont(20));
                tmpSkin.add("article", CreateResultFont(30));
            }
        }
        tmpSkin.addRegions(basic_atlas);
        Label.LabelStyle lStyle = new Label.LabelStyle();
        lStyle.background = new TextureRegionDrawable(tmpSkin.getRegion("basic_label"));
        lStyle.font = tmpSkin.getFont("result");
        tmpSkin.add("result",lStyle);

        tmpSkin.addRegions(basic_atlas);
        lStyle = new Label.LabelStyle();
        lStyle.background = new TextureRegionDrawable(tmpSkin.getRegion("basic_label"));
        lStyle.font = tmpSkin.getFont("article");
        tmpSkin.add("article",lStyle);

        return tmpSkin;
    }

    public String getUrl(){
        return "url";
    }
}
