PHP_FILES := $(wildcard ../*.php) $(wildcard ../pages/*.php)
PO_FILES := $(wildcard emloginas-*.po)
MO_FILES := $(patsubst %.po,%.mo,$(PO_FILES))

POT := emloginas.pot

XGETTEXT := xgettext
MSGFMT := msgfmt
MSGMERGE := msgmerge
XGETTEXT_OPTIONS := --default-domain=emloginas --language=php \
	--keyword=__ \
	--keyword=_e \
	--keyword=_c \
	--keyword=esc_attr__ \
	--keyword=esc_html__ \
	--keyword=esc_attr_e \
	--keyword=esc_html_e \
	--keyword=_x \
	--keyword=esc_attr_x \
	--keyword=_n \
	--keyword=_nc \
	--keyword=_nx \
	--from-code=UTF-8 --msgid-bugs-address='vladimir@extrememember.com'

.PHONY: all
all: $(POT) $(MO_FILES)

$(MO_FILES): %.mo: %.po
	$(MSGFMT) -o$@ $<

$(PO_FILES): %: $(POT)
	$(MSGMERGE) -U $@ $(POT)
	touch $@

$(POT): $(PHP_FILES)
	$(XGETTEXT) $(XGETTEXT_OPTIONS) $(PHP_FILES) --output="$@"

.PHONY: clean
clean:
	-rm -f $(POT) $(MO_FILES)
